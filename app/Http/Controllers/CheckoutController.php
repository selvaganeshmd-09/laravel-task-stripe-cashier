<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login first.');
        }

        return view('checkout.show', compact('product'));
    }

    public function success($uuid)
    {
        $checkout = Checkout::where('uuid', $uuid)->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please login first.');
        }

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
                'status' => 'completed',
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
                'status' => 'failed',
                'stripe_response' => json_encode($e->getMessage()),
            ]);

            \Log::error('Stripe Checkout Error: '.$e->getMessage());
            return redirect()->route('checkout.failed')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function webhook(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        $object = $event->data->object;

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $checkout = Checkout::where('stripe_payment_id', $object->id)->first();
                if ($checkout) {
                    $checkout->update(['status' => 'success']);
                }
                break;

            case 'payment_intent.payment_failed':
                $checkout = Checkout::where('stripe_payment_id', $object->id)->first();
                if ($checkout) {
                    $checkout->update([
                        'status' => 'failed',
                        'error_message' => $object->last_payment_error->message ?? 'Unknown error'
                    ]);
                }
                break;
        }

        return response()->json(['received' => true]);
    }

}
