@extends('backend.layout.app')
@section('title', 'Checkout')

@section('main-content')

<style>
.checkout-box {
    padding: 25px;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.08);
}
.breadcrumb-area {
    background: url('/assets/img/checkout-bg.jpg');
    padding: 50px 0;
    color: #fff;
}
.payment-box label {
    cursor: pointer;
}
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-area">
    <div class="container">
        <h2 class="fw-bold">Checkout Page</h2>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}" class="text-white">Home</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">

    <div class="row justify-content-center">

        <!-- BILLING DETAILS -->
        <div class="col-lg-7">
            <div class="checkout-box">

                <h4 class="mb-3">Billing Details</h4>

                <form id="checkoutForm" method="POST" action="{{ route('checkout.place') }}">
                    @csrf

                    <div class="row">

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ $user->name }}" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $user->email }}" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control"
                                   value="Pakistan" readonly>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="street_address" class="form-control" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" required>
                        </div>

                    </div>

                    <input type="hidden" name="cart_total" value="{{ $cartTotal }}">
                </form>

            </div>
        </div>

        <!-- CART TOTAL & PAYMENT -->
        <div class="col-lg-5">
            <div class="checkout-box">

                <h5 class="mb-3">Cart Totals</h5>

                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong>Rs {{ number_format($cartTotal) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Shipping</span>
                        <strong>Rs 0</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rs {{ number_format($cartTotal) }}</strong>
                    </li>
                </ul>

                <h6>Payment Method</h6>

                <div class="payment-box mb-3">

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio"
                               name="payment_method" value="COD" form="checkoutForm" required>
                        <label class="form-check-label">Cash On Delivery</label>
                        <p class="text-muted small">Pay with cash upon delivery.</p>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="payment_method" value="ONLINE" form="checkoutForm">
                        <label class="form-check-label">JazzCash / EasyPaisa</label>
                        <p class="text-muted small">Send payment to <strong>03074017108</strong></p>
                    </div>

                </div>

                <button class="btn btn-primary w-100"
                        onclick="document.getElementById('checkoutForm').submit();">
                    Place Order
                </button>

            </div>
        </div>

    </div>
</div>

@endsection
