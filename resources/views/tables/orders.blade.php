<div class="container">
    <h1>Orders for Table {{ $table }}</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Table</th>
            <th>Menu Item</th>
            <th>Quantity</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->table }}</td>
                <td>{{ $order->menu_item }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
