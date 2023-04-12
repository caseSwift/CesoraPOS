@extends('layouts.app')

@section('content')
    <h1>Sales Report Results</h1>

    <p>Showing sales report for {{ $startDate }} to {{ $endDate }}:</p>

    <table class="table">
        <thead>
        <tr>
            <th>Item Name</th>
            <th>Quantity Sold</th>
            <th>Total Sales</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($salesReportData as $item)
            <tr>
                <td>{{ $item->article_name }}</td>
                <td>{{ $item->total_quantity }}</td>
                <td>{{ $item->total_sales }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
