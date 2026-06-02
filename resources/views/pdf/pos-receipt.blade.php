<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 13px;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }
        .right { text-align: right; }

        .info { margin-bottom: 6px; }

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

        td { padding: 4px 4px; }

        .totals { text-align: right; margin-top: 3px; }

        .grand-total {
            font-size: 15px;
            font-weight: bold;
            text-align: right;
            margin-top: 8px;
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
        Branch: {{ $order->branch->name ?? 'N/A' }}
    </div>

    <p class="info bold">Invoice: {{ $order->invoice }}</p>
    <p class="info">
        INV. Date: {{ $order->place_date ? \Carbon\Carbon::parse($order->place_date)->format('d-m-Y') : '' }}
    </p>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="right">Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->orders as $item)
                @php
                    $unitPrice = $item->qty ? $item->price / $item->qty : 0;
                @endphp
                <tr>
                    <td>{{ $item->productPrice->product->name ?? 'N/A' }}</td>
                    <td>
                        {{ $item->qty ?? 'N/A' }} ×
                        {{ $unitPrice }} BDT
                    </td>
                    <td class="right">
                        {{ $item->price }} BDT
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <p class="totals">
        Payable Price: {{ $order->payable_price }} BDT
    </p>

    <p class="totals">
        Discount:
        {{ discountedPrice($order) }} BDT
    </p>
  
    <p class="totals">
        Due: {{ $order->due_amount }} BDT
    </p>
    <p class="grand-total">
        Paid: {{ $order->total_paid }} BDT
    </p>

    <hr>

    <div class="center" style="font-size:12px;">
        Thank you for shopping!
    </div>

</body>
</html>
