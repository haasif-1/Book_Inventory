@extends('backend.layout.app')
@section('title', 'Order Detail')

@section('main-content')

    <div class="container py-4">

        <h4>Order #{{ $order->id }}</h4>

        <div class="row">

            <!-- ITEMS -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">Items</div>
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="row mb-3 border-bottom pb-2">
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid">
                                </div>
                                <div class="col-9">
                                    <h6>{{ $item->product->title }}</h6>
                                    <p>Qty: {{ $item->qty }}</p>
                                    <p>Price: {{ number_format($item->price) }}</p>
                                    <p><strong>Subtotal:</strong> {{ number_format($item->subtotal) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- USER + ADDRESS + STATUS -->
            <div class="col-lg-4">

                <div class="card mb-3">
                    <div class="card-header">User Info</div>
                    <div class="card-body">
                        <p>{{ $order->user->name }}</p>
                        <p>{{ $order->user->email }}</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">Shipping Address</div>
                    <div class="card-body">
                        <p>{{ $order->address->street_address }}</p>
                        <p>{{ $order->address->city }}, {{ $order->address->state }}</p>
                        <p>{{ $order->address->country }} - {{ $order->address->postal_code }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Update Status</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
                            @csrf
                            <select name="status" class="form-select">
                                <option value="processing">Processing</option>
                                <option value="packed">Packed</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button class="btn btn-primary w-100 mt-2">Update</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
