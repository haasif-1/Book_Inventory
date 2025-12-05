@extends('backend.layout.app')
@section('title', 'Client Dashboard')

@section('main-content')

    <style>
        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: 0.2s;
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            background: #fafafa;
        }

        .price-main {
            font-size: 18px;
            font-weight: bold;
            color: #e96a0a;
        }

        .price-old {
            text-decoration: line-through;
            color: #888;
            font-size: 14px;
        }

        .discount {
            color: #008000;
            font-size: 14px;
            font-weight: 600;
        }

        .add-cart-icon {
            font-size: 22px;
            cursor: pointer;
        }
    </style>

    <div class="container py-4">

        <h4 class="fw-semibold mb-4">Recommended for you</h4>

        <div class="row g-3">

            @foreach ($products as $p)
                @php
                    $discountPrice = $p->sell_price - $p->sell_price * 0.1; // 10% off
                @endphp

                <div class="col-6 col-md-4 col-lg-2"> {{-- 5 cards per row exact --}}
                    <div class="product-card p-2">

                        <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('noimg.png') }}">

                        <div class="p-2">
                            <p class="fw-semibold text-truncate">{{ $p->title }}</p>

                            <p class="price-main">Rs.{{ number_format($discountPrice) }}</p>

                            <p class="price-old">Rs.{{ number_format($p->sell_price) }}</p>

                            <p class="discount">-10%</p>

                            <div class="text-end">
                                <i class="ti ti-shopping-cart add-cart-icon" onclick="addToCart({{ $p->id }})"></i>

                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-4">
            <div>
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>

    <script>
        function addToCart(productId) {

            fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);

                    if (data.success) {
                        document.getElementById('cartCount').textContent = data.cart_count;
                    }
                });
        }
    </script>


@endsection
