@extends('backend.layout.app')
@section('title', 'My Cart')

@section('main-content')

    <style>
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 14px 0;
        }

        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f9f9f9;
        }

        .qty-box {
            width: 60px;
            text-align: center;
        }
    </style>

    <div class="container py-4">

        <h4 class="fw-semibold mb-4">My Cart</h4>

        @if ($items->isEmpty())
            <p class="text-muted">Your cart is empty.</p>
        @else
            <div id="cartContainer">
                @foreach ($items as $item)
                    <div class="row align-items-center cart-item" id="cartRow{{ $item->id }}">

                        <div class="col-md-1">
                            <img src="{{ asset('storage/' . $item->image) }}" class="cart-img">
                        </div>

                        <div class="col-md-4">
                            <p class="fw-bold mb-1">{{ $item->product->title }}</p>
                            <p class="text-muted mb-0">Rs.{{ number_format($item->price) }}</p>
                        </div>

                        <div class="col-md-3 d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="updateQty({{ $item->id }}, 'minus')">-</button>

                            <input type="text" class="form-control mx-2 qty-box" id="qtyInput{{ $item->id }}"
                                value="{{ $item->qty }}" readonly>

                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="updateQty({{ $item->id }}, 'plus')">+</button>
                        </div>

                        <div class="col-md-2 fw-bold">
                            Rs.{{ number_format($item->price * $item->qty) }}
                        </div>

                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-danger" onclick="removeItem({{ $item->id }})">
                                Remove
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- CHECKOUT BUTTON -->
            <div class="mt-4 text-end">
                <a href="{{ route('checkout.show') }}" class="btn btn-primary px-4">
                    Proceed to Checkout
                </a>
            </div>

        @endif

    </div>

    <!-- FIXED WORKING JS -->
    <script>
        function updateQty(cartId, action) {
            fetch(`/client/cart/update/${cartId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        action: action
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.message);
                        return;
                    }
                    location.reload(); // reload to update totals
                });
        }

        function removeItem(cartId) {
            if (!confirm("Remove this item?")) return;

            fetch(`/client/cart/remove/${cartId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
        }

        function updateCartCount() {
            fetch(`{{ route('cart.count') }}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cartCount').textContent = data.count;
                });
        }
    </script>

@endsection
