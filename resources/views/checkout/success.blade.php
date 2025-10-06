@extends('layouts.app')

@section('content')
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 text-center p-5">


                    <div class="d-flex justify-content-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 64 64">
                            <!-- Outer Circle with border + shadow -->
                            <circle cx="32" cy="32" r="30" fill="#ff6b35" stroke="#fff0eb" stroke-width="3" />

                            <!-- Check Mark -->
                            <line x1="20" y1="34" x2="28" y2="42" stroke="#fff"
                                stroke-width="5" stroke-linecap="round" />
                            <line x1="28" y1="42" x2="44" y2="26" stroke="#fff"
                                stroke-width="5" stroke-linecap="round" />
                        </svg>

                    </div>

                    <h1 class="mb-3 text-theme fw-bold">Payment Successful!</h1>

                    <p class="mb-4 text-muted fs-5">
                        Your order has been processed successfully for the below details:
                    </p>

                    <ul class="list-group list-group-flush mb-4 text-start fs-6">
                        <li class="list-group-item"><strong>Product:</strong> {{ $checkout->product->name }}</li>
                        <li class="list-group-item"><strong>Amount:</strong>
                            ₹{{ number_format($checkout->product->price, 2) }}
                        </li>
                        <li class="list-group-item"><strong>Stripe Payment ID:</strong> {{ $checkout->stripe_payment_id }}
                        </li>
                    </ul>

                    <a href="{{ route('products.index') }}" class="btn btn-theme rounded-pill">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
