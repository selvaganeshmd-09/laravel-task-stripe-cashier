<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Product;
use App\Models\Checkout;
use Auth;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', '0');
        });
    }

    public function show($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();

        return view('checkout.show', compact('product'));
    }

    public function success($uuid)
    {
        $checkout = Checkout::where('uuid', $uuid)->firstOrFail();

        return view('checkout.success', compact('checkout'));
    }

    public function failed()
    {
        return view('checkout.failed');
    }

    public function process(Request $request, $uuid)
    {

        $product = Product::where('uuid', $uuid)->firstOrFail();
        $user = Auth::user();

        // If customer not exists
        if (!$user->stripe_id) {
            $user->createAsStripeCustomer([
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $request->phone,
                'address' => [
                    'line1'       => $request->street,
                    'city'        => $request->city,
                    'state'       => $request->state,
                    'postal_code' => $request->zip,
                    'country'     => $request->country,
                ]
            ]);
        }

        $user->updateDefaultPaymentMethod($request->payment_method);

        try {
            $amount_in_paise = round($product->price * 100);

            $charge = $user->charge($amount_in_paise, $request->payment_method, [
                'currency' => 'inr',
                'metadata' => [
                    'product_id' => $product->id,
                    'stripe_product_id' => $product->stripe_product_id,
                    'stripe_price_id' => $product->stripe_price_id,
                    'user_id' => $user->id,
                ]
            ]);

            $checkout = Checkout::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'stripe_product_id' => $product->stripe_product_id,
                'stripe_price_id' => $product->stripe_price_id,
                'stripe_payment_id' => $charge->id,
                'amount' => $product->price,
                'billing_name' => $request->name,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_street' => $request->street,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => $request->zip,
                'billing_country' => $request->country,
                'stripe_response' => json_encode($charge),
            ]);

            return redirect()->route('checkout.success', $checkout->uuid);

        } catch (\Exception $e) {
            Checkout::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'amount' => $product->price,
                'stripe_response' => json_encode($e->getMessage()),
            ]);

            \Log::error('Stripe Checkout Error: '.$e->getMessage());
            return redirect()->route('checkout.failed')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        //Log::error("Stripe Webhook payload:".json_encode($payload));
        $signature_header = $request->header('Stripe-Signature');

        $webhook_secret = env('STRIPE_WEBHOOK_SECRET');
        //Log::error("Stripe Webhook: Signature header missing.");

        if (!$signature_header) {
            //Log::error("Stripe Webhook: Signature header missing.");
            return response()->json(['error' => 'Signature not found'], 400);
        }

        try {
            $event = Webhook::constructEvent($payload, $signature_header, $webhook_secret);
        } catch (SignatureVerificationException $e) {
            Log::error("Stripe Webhook: Invalid signature - " . $e->getMessage());
            return response()->json(['error' => 'Invalid Signature'], 400);
        } catch (\Exception $e) {
            Log::error("Stripe Webhook Error: " . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);
        }

        $paymentIntent = $event->data->object;
        $status = $paymentIntent->status;

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->updatePaymentStatus($paymentIntent->id, 'succeeded');
                break;

            case 'payment_intent.payment_failed':
                $this->updatePaymentStatus($paymentIntent->id, 'failed');
                break;

            case 'payment_intent.canceled':
                $this->updatePaymentStatus($paymentIntent->id, 'canceled');
                break;

            default:
        }

        return response()->json(['message' => 'Webhook received']);
    }


    private function updatePaymentStatus($stripePaymentId, $status)
    {
        $payment = Checkout::where('stripe_payment_id', $stripePaymentId)->first();

        if ($payment) {
            $payment->update(['status' => $status]);
        } else {
            Log::warning("Stripe Webhook Warning: Payment not found for ID - " . $stripePaymentId);
        }
    }
}