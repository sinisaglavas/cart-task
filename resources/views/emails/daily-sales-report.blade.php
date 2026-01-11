<p>Hello Admin,</p>

<p>Here is the sales report for <strong>{{ $date->toDateString() }}</strong>:</p>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
    <tr>
        <th>Product</th>
        <th>Quantity Sold</th>
        <th>Total Revenue</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($report as $row)
        <tr>
            <td>{{ $row['product'] }}</td>
            <td>{{ $row['quantity'] }}</td>
            <td>${{ number_format($row['revenue'], 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p>Regards,<br>Laravel App</p>


