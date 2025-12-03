@extends('backend.layout.app')
@section('title','Low Stock Alerts')
@section('main-content')

<div class="container-fluid py-4">

    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between">
            <h4 class="mb-0">Low Stock Products</h4>

            <form method="GET" action="{{ route('admin.lowstock') }}" class="d-flex">
                <select name="threshold" class="form-select form-select-sm me-2" style="width:150px;">
                    <option value="">Min Stock Only</option>
                    <option value="5" {{ request('threshold')=='5'?'selected':'' }}>Below 5</option>
                    <option value="10" {{ request('threshold')=='10'?'selected':'' }}>Below 10</option>
                    <option value="20" {{ request('threshold')=='20'?'selected':'' }}>Below 20</option>
                </select>
                <button class="btn btn-primary btn-sm">Filter</button>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Min Stock</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $i => $p)

                            @php
                                $isLow = $p->stock <= $p->min_stock;
                            @endphp

                            <tr class="{{ $isLow ? 'table-danger' : '' }}">
                                <td>{{ $i+1 }}</td>
                                <td>
                                    @if($p->image)
                                    <img src="{{ asset('storage/'.$p->image) }}" width="70">
                                    @endif
                                </td>
                                <td>{{ $p->title }}</td>
                                <td>{{ $p->sku }}</td>
                                <td>{{ $p->stock }}</td>
                                <td>{{ $p->min_stock }}</td>
                                <td>{{ $p->location }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No Products Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
