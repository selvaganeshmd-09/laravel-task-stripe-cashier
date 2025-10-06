@extends('layouts.app')

@section('content')
    <div class="container mt-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="/" class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-house-door me-1" viewBox="0 0 16 16">
                            <path
                                d="M8.354 1.146a.5.5 0 0 0-.708 0L1 7.793V14.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V11h2v3.5A1.5 1.5 0 0 0 10.5 16h3a1.5 1.5 0 0 0 1.5-1.5V7.793l-6.146-6.647zM2 14V8.5L8 2l6 6.5V14a.5.5 0 0 1-.5.5h-3A.5.5 0 0 1 10 14v-3.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V14a.5.5 0 0 1-.5.5h-3A.5.5 0 0 1 2 14z" />
                        </svg>
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item"><a href="/">Product</a></li>

                <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row py-3">

            <div class="col-md-6">
                <div class="card shadow-lg border-0 py-4">
                    <div class="card-body p-4">


                        <div class="text-center mb-3">
                            <span class="badge badge-theme">Checkout Item</span>
                        </div>


                        <div class="d-flex align-items-center mb-3">
                            <span class="shop-icon-inner me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 32 32"
                                    fill="#fb633a">
                                    <g id="shopping_bag" data-name="shopping bag">
                                        <path
                                            d="M25.18,10.73a3,3,0,0,0-3-2.73H22A6,6,0,0,0,10,8H9.84a3,3,0,0,0-3,2.73L5.23,26.67a3,3,0,0,0,3,3.33H23.76a3,3,0,0,0,3-3.33Zm-.66,16.93a1,1,0,0,1-.76.34H8.24a1,1,0,0,1-.76-.34,1,1,0,0,1-.26-.79L8.81,10.93a1,1,0,0,1,1-.93H10v2a1,1,0,0,0,2,0V10h5a1,1,0,0,0,0-2H12a4,4,0,0,1,8,0v4a1,1,0,0,0,2,0V10h.16a1,1,0,0,1,1,.93l1.59,15.94A1,1,0,0,1,24.52,27.66Z" />
                                    </g>
                                </svg>
                            </span>
                            <h4 class="product-title-inner mb-0">{{ $product->name }}</h4>
                        </div>


                        <p class="product-description-inner my-4">
                            {{ $product->description }}
                        </p>

                        <div>
                            <h5 class="product-price">₹{{ number_format($product->price, 2) }}</h5>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-lg border-0 py-4">
                    <div class="card-body p-4">

                        <form id="payment-form" action="{{ route('checkout.process', $product->uuid) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ auth()->user()->name ?? '' }}" pattern="[A-Za-z\s]{2,50}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ auth()->user()->email ?? '' }}" required>

                            </div>

                            <div class="mb-3">
                                <label for="billing-phone" class="form-label">Phone Number</label>
                                <input type="text" id="billing-phone" name="phone" class="form-control"
                                    placeholder="Enter 10-digit phone number" pattern="\d{10}" maxlength="10" required>
                                <div class="form-text">Enter exactly 10 digits.</div>
                            </div>


                            <div class="mb-3">
                                <label for="billing-address" class="form-label">Street Address</label>
                                <input type="text" id="billing-address" name="street" class="form-control"
                                    placeholder="123 Main Street" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="billing-city" class="form-label">City</label>
                                    <input type="text" id="billing-city" name="city" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="billing-state" class="form-label">State</label>
                                    <input type="text" id="billing-state" name="state" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="billing-zip" class="form-label">ZIP</label>
                                    <input type="text" id="billing-zip" name="zip" class="form-control"
                                        maxlength="6" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="billing-country" class="form-label">Country</label>
                                <select id="billing-country" name="country" class="form-select" required>
                                    <option value="IN" selected>India</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Card Details</label>
                                <div id="card-element" class="py-3 form-control mb-2"></div>
                                <div id="card-errors" class="text-danger mb-2"></div>
                            </div>

                            <button type="submit" class="btn btn-buy-now w-100">Pay Now
                                ₹{{ number_format($product->price, 2) }}</button>
                        </form>


                    </div>
                </div>


            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        // OnKeyup val
        $(document).ready(function() {
            $('#name').on('keyup', function() {
                $(this).val($(this).val().replace(/[^A-Za-z\s]/g, ''));
            });

            $('#billing-phone, #billing-zip').on('keyup', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });
        });
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('billing-phone').value,
                    address: {
                        line1: document.getElementById('billing-address').value,
                        city: document.getElementById('billing-city').value,
                        state: document.getElementById('billing-state').value,
                        postal_code: document.getElementById('billing-zip').value,
                        country: document.getElementById('billing-country').value
                    }
                }
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                if (!paymentMethod || !paymentMethod.id) {
                    document.getElementById('card-errors').textContent =
                        'Payment Method not created. Try again.';
                    return;
                }

                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);

                form.submit();
            }
        });
    </script>
@endpush
