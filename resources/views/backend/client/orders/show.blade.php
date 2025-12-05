@extends('backend.layout.app')
@section('title', 'Order Detail')

@section('main-content')

<div class="container py-4">

    <h4 class="fw-semibold mb-3">Order #{{ $order->id }}</h4>

    <div class="row">
        <!-- LEFT: ORDER ITEMS -->
        <div class="col-lg-8">

            <div class="card mb-3">
                <div class="card-header"><strong>Items</strong></div>
                <div class="card-body">

                    @foreach($order->items as $item)
                    <div class="row mb-3 border-bottom pb-2">

                        <div class="col-3">
                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 class="img-fluid rounded">
                        </div>

                        <div class="col-9">
                            <h6>{{ $item->product->title }}</h6>
                            <p>Qty: {{ $item->qty }}</p>
                            <p>Price: Rs {{ number_format($item->price) }}</p>
                            <p class="fw-bold">Subtotal: Rs {{ number_format($item->subtotal) }}</p>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>

        </div>

        <!-- RIGHT: SHIPPING INFO -->
        <div class="col-lg-4">

            <div class="card mb-3">
                <div class="card-header"><strong>Shipping Address</strong></div>
                <div class="card-body">
                    <p>{{ $order->address->first_name }} {{ $order->address->last_name }}</p>
                    <p>{{ $order->address->email }}</p>
                    <p>{{ $order->address->phone }}</p>
                    <p>{{ $order->address->street_address }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->state }}</p>
                    <p>{{ $order->address->country }} - {{ $order->address->postal_code }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Payment Summary</strong></div>
                <div class="card-body">
                    <p>Method: {{ strtoupper($order->payment_method) }}</p>
                    <p>Status:
                        <span class="badge bg-success">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <h5>Total: Rs {{ number_format($order->total_amount) }}</h5>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
