@extends('backend.layout.app')
@section('title', 'My Orders')

@section('main-content')

<div class="container py-4">
    <h4 class="fw-semibold mb-4">My Orders</h4>

    @if ($orders->isEmpty())
        <p class="text-muted">No orders found.</p>
    @else

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#Order ID</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $o)
                    <tr>
                        <td>#{{ $o->id }}</td>
                        <td>Rs {{ number_format($o->total_amount) }}</td>
                        <td>{{ strtoupper($o->payment_method) }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($o->order_status) }}</span>
                        </td>
                        <td>{{ $o->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="{{ route('client.orders.show', $o->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>

                            {{-- CANCEL BUTTON --}}
                            @if ($o->order_status == 'processing')
                                <form method="POST" action="{{ route('client.order.cancel', $o->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Cancel this order?')">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PAGINATION --}}
        {{ $orders->links('pagination::bootstrap-5') }}

    @endif
</div>

@endsection
