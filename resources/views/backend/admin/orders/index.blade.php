@extends('backend.layout.app')
@section('title', 'Orders')

@section('main-content')

    <div class="container py-4">

        <h4 class="fw-semibold mb-3">All Orders</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $o)
                    <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->user->name }}<br>{{ $o->user->email }}</td>
                        <td>Rs {{ number_format($o->total_amount) }}</td>
                        <td>{{ strtoupper($o->payment_method) }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($o->order_status) }}</span></td>
                        <td>{{ $o->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links('pagination::bootstrap-5') }}

    </div>

@endsection
