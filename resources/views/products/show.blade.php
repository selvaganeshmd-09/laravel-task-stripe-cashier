@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
        <p><strong>Price: ₹{{ $product->price / 100 }}</strong></p>

        <form id="payment-form" action="{{ route('products.checkout', $product->id) }}" method="POST">
            @csrf
            <!-- Customer Info -->
            <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" class="form-control mb-2" required>
            <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="form-control mb-2" required>

            <!-- Card -->
            <div id="card-element" class="form-control mb-3"></div>
            <div id="card-errors" class="text-danger mb-2"></div>

            <button class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        const paymentForm = document.getElementById('payment-form');

        paymentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const {
                token,
                error
            } = await stripe.createToken(card, {
                name: paymentForm.name.value,
                email: paymentForm.email.value
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                paymentForm.appendChild(hiddenInput);

                paymentForm.submit(); // ✅ works now
            }
        });
    </script>
@endsection
