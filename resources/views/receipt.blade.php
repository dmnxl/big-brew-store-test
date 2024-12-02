<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 10px;
        }
        .receipt {
            max-width: 80mm;
            margin: auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .receipt h3 {
            text-align: center;
            color: #333;
            font-size: 1.2em;
        }
        .receipt p {
            margin: 5px 0;
            font-size: 0.8em;
            color: #555;
        }
        .receipt ul {
            list-style-type: none;
            padding: 0;
        }
        .receipt li {
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }
        .receipt li:last-child {
            border-bottom: none;
        }
        .receipt li strong {
            display: block;
            font-size: 1em;
            color: #333;
        }
        .receipt .total {
            font-size: 1.2em;
            color: #333;
            text-align: right;
        }
        @media print {
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                margin: 0;
                width: 100%;
                max-width: none;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h3>Order Receipt</h3>
        <p><strong>Date:</strong> {{ $date }}</p>

        <ul>
            @foreach($orderDetails as $item)
                <li>
                    <strong>{{ $item['productName'] }}</strong>
                    <p>Quantity: {{ $item['quantity'] }}</p>
                    @if (!empty($item['addOns']))
                        <p>Add-ons: {{ implode(', ', $item['addOns']) }}</p>
                    @endif
                    <p>Total: ${{ number_format($item['total'], 2) }}</p>
                </li>
            @endforeach
        </ul>

        <p class="total"><strong>Total:</strong> ${{ number_format($totalAmount, 2) }}</p>
    </div>
</body>
</html>
