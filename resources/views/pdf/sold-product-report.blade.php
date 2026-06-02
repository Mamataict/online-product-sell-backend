<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 13px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .info {
            margin-bottom: 6px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }

        td {
            padding: 4px 4px;
        }

        .totals {
            text-align: right;
            margin-top: 3px;
        }

        .delivery-fee {
            text-align: right;
            margin-top: 3px;
        }

        .grand-total {
            font-size: 15px;
            font-weight: bold;
            text-align: right;
            margin-top: 8px;
        }

        .signature {
            margin-top: 20px;
            float: left;
        }
    </style>
</head>

<body>

    <p class="info">Print Date: {{ now()->format('d-m-Y') }}</p>

    <div class="center">
        <img src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}" width="70" height="70">
    </div>

    <div class="center bold" style="font-size:16px;margin-top:4px;">
        Dairy Fresh
    </div>


    <div class="center bold" style="margin-top:2px;">
        BILL (PRODUCT SALE)
    </div>

    <hr>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>

            @if ($products->count() > 0)
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->order_info?->place_date }}</td>
                    <td>{{ $product->order_info?->invoice }}</td>
                    <td>{{ $product->productPrice?->product?->name }}</td>
                    <td>{{ $product->order_info?->customer?->name }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="6" class="center">No products found.</td>
                </tr>
            @endif
        </tbody>

    </table>

    <table width="100%" style="margin-top: 50px; text-align: center;">
        <tr>
            <td>
                _____________<br>
                Prepared By
            </td>

            <td style="padding: 0px 2px 0px 2px;">
                _____________<br>
                Delivered By
            </td>

            <td style="padding: 10px;">
                _____________<br>
                Received By
            </td>
        </tr>
    </table>
</body>

</html>
