@extends('layouts.app')
@section('header')
    <a class="btn btn-outline-primary" href="{{ route('main') }}">Back to Main</a>
@endsection

@section('content')

    <div class="container">
        <h1>Void Orders</h1>

        <form method="POST" action="{{ route('void-orders') }}">
            @csrf

            <div class="form-group">
                <label for="user_id">Select user:</label>
                <select class="form-select" name="user_id" id="user_id" required>
                    <option value="">Select user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Show Orders</button>
        </form>

        @if ($orders)
            <h2>Orders for {{ $user->name }}</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Table ID</th>
                    <th>Order ID</th>
                    <th>Void</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->fk_table_id }}</td>
                        <td>{{ $order->order_id }}</td>

                        <td>
                            <button type="button" class="btn btn-danger void-order" data-order-id="{{ $order->order_id }}">Void</button>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
    <script>

        const voidOrderButtons = document.querySelectorAll('.void-order');

        voidOrderButtons.forEach(button => {
            button.addEventListener('click', () => {
                const orderId = button.dataset.orderId;
                fetch(`/void-order/${orderId}`, { method: 'POST' })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to void order');
                        }
                        location.reload();
                        // Reload the page or update the UI as needed
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
