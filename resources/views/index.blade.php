<?php
<html>
<head>
    <title>Admin Deliveries</title>
</head>
<body>
    <h1>Admin Deliveries</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>City</th>
            <th>Address</th>
            <th>Delivery Date</th>
            <th>Client Name</th>
            <th>Client Phone</th>
            <th>Status</th>
        </tr>
@foreach ($deliveries as $delivery)
    <tr>
        <td>{{ $delivery->id }}</td>
        <td>{{ $delivery->city->name }}</td>
        <td>{{ $delivery->address }}</td>
        <td>{{ $delivery->delivery_date }}</td>
        <td>{{ $delivery->client_name }}</td>
        <td>{{ $delivery->client_phone }}</td>
        <td>
            <form method="post" action="{{ route('admin.deliveries.update', $delivery->id) }}">
                @csrf
                @method('put')
                <select name="status">
                    <option value="новый" {{ $delivery->status === 'новый' ? 'selected' : '' }}>New</option>
                    <option value="доставлен" {{ $delivery->status === 'доставлен' ? 'selected' : '' }}>Delivered</option>
                    <option value="отменён" {{ $delivery->status === 'отменён' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </td>
    </tr>
    @endforeach
    </table>
    {{ $deliveries->links() }}
    </body>
    </html>
