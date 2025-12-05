<h2>Invoice #{{ $order->id }}</h2>
<p>Date: {{ $order->created_at->format('d M Y') }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>
    @foreach ($order->items as $item)
        <tr>
            <td>{{ $item->product->title }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->subtotal }}</td>
        </tr>
    @endforeach
</table>

<h3>Total: Rs {{ $order->total_amount }}</h3>
