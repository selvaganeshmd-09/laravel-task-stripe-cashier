@extends('layouts.app')

@section('content')
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 text-center p-5">

                    <div class="d-flex justify-content-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none">

                            <circle cx="12" cy="12" r="10" stroke="#ffebeb" stroke-width="2" fill="#f8d7da" />

                            <line x1="8" y1="8" x2="16" y2="16" stroke="#dc3545"
                                stroke-width="2" stroke-linecap="round" />
                            <line x1="16" y1="8" x2="8" y2="16" stroke="#dc3545"
                                stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>

                    <h1 class="mb-3 text-danger fw-bold">Payment Failed!</h1>

                    <p class="mb-4 text-muted fs-5">
                        Payment failed. No amount has been charged. Please try again later.
                    </p>

                    <a href="{{ route('products.index') }}" class="btn btn-danger rounded-pill px-5 py-2 fs-6">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
