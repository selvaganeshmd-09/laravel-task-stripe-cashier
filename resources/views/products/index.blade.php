@extends('layouts.app')

@section('content')
    <div class="container">


        <section class="page-title-section text-center py-5 mb-4">
            <h1 class="display-4 fw-bold mb-2">Our Products</h1>
            <p class="lead text-muted">Explore our wide range of products and choose your favorite.</p>
        </section>

        <section class="product-grid text-center py-5 mb-4">
            @if ($products->isEmpty())
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            <h4 class="mb-0">No products found!</h4>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card product-card border-0 shadow-lg h-100">
                                <div class="card-body text-center p-4 d-flex flex-column justify-content-between">

                                    <h5 class="fw-bold mb-3 text-dark">{{ $product->name }}</h5>

                                    <p class="price-tag mb-4">₹{{ number_format($product->price, 2) }}</p>

                                    @if (auth()->check())
                                        <a href="{{ route('checkout.show', $product->uuid) }}"
                                            class="btn btn-buy-now mt-auto">Buy
                                            Now</a>
                                    @else
                                        <button class="btn btn-buy-now mt-auto" onclick="showLoginAlert()">Buy Now</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

        </section>

        {{-- Pagination --}}
        <nav>
            <ul class="pagination justify-content-center">

                {{-- Previous Page --}}
                <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}">«</a>
                </li>

                @php
                    $start = max(1, $products->currentPage() - 2);
                    $end = min($products->lastPage(), $products->currentPage() + 2);
                @endphp

                {{-- First Page --}}
                @if ($start > 1)
                    <li class="page-item"><a class="page-link" href="{{ $products->url(1) }}">1</a></li>
                    @if ($start > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                {{-- Middle Pages --}}
                @for ($i = $start; $i <= $end; $i++)
                    <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Last Page --}}
                @if ($end < $products->lastPage())
                    @if ($end < $products->lastPage() - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item"><a class="page-link"
                            href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a></li>
                @endif

                {{-- Next Page --}}
                <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}">»</a>
                </li>

            </ul>
        </nav>

        @endif
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showLoginAlert() {
            Swal.fire({
                title: "Login Required",
                text: "Please log in to buy this product.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Login",
                cancelButtonText: "Cancel",
                background: '#ffffff',
                color: '#000000',
                confirmButtonColor: '#fb633a',
                cancelButtonColor: '#555',
                customClass: {
                    popup: 'swal-popup shadow-lg rounded-3 p-4',
                    confirmButton: 'swal-confirm-btn',
                    cancelButton: 'swal-cancel-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    </script>
@endsection
