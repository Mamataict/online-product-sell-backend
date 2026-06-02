<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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

    @if ($order->branch && $order->branch->users->isNotEmpty())
        <div class="center bold" style="margin-top:2px;">
            Branch: {{ $order->branch->name ?? 'N/A' }}, {{ $order->branch->address ?? 'N/A' }},

            Sales Person : {{ $order->branch->users->first()->name }} ({{ $order->branch->users->first()->username }})
        </div>
    @endif

    <div class="center bold" style="margin-top:2px;">
        BILL (DISCOUNT)
    </div>

    <p class="info bold">Invoice: {{ $order->invoice }}</p>
    <p class="info">
        INV. Date: {{ $order->place_date ? \Carbon\Carbon::parse($order->place_date)->format('d-m-Y') : '' }}
    </p>

    <p class="info bold">Customer: {{ $order->customer->name ?? 'N/A' }}</p>
    <p class="info bold">Remark: {{ $order->remark ?? 'N/A' }}</p>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Total</th>

                <th>Adj. qty</th>
                <th>Adj. reason</th>
                <th>Adj. Type</th>
                <th>Adj. By</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->orders as $item)
                @php
                    $unitPrice = $item->qty ? $item->price / $item->qty : 0;
                @endphp
                <tr>
                    <td>{{ $item->productPrice->product->name ?? 'N/A' }}</td>
                    <td>
                        {{ $item->qty ?? 'N/A' }} ×
                        {{ $unitPrice }} BDT
                    </td>
                    <td>
                        {{ $item->price }}
                        BDT
                    </td>

                    <td className="p-3 text-center">
                      {{$item->adjustment?->amount
                        ? Number($item->adjustment->amount ?? 0)
                        : "N/A"}}
                    </td>
                    <td className="p-3 text-center">
                      {{$item->adjustment?->reason ?? "N/A"}}
                    </td>
                    <td className="p-3 text-center">
                      {{ $item->adjustment?->type
                        ? $item->adjustment->type == "refund"
                          ? "Refund"
                          : "Replace"
                        : "N/A"}}
                    </td>
                    <td className="p-3 text-center">
                      {{ $item->adjustment?->creator
                        ? $item->adjustment->creator->name
                        : "N/A"}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>


    <p class="totals">
        Payable Price:
        {{ $order->payable_price }}
        BDT
    </p>

    <p class="totals">
        Discount: {{ discountedPrice($order) }} BDT
    </p>

    <p class="delivery-fee">
        Delivery Fee:
        {{ $order->delivery_fee }}
        BDT
    </p>
    <p class="grand-total">
        Paid:
        {{ $order->total_paid }}
        BDT
    </p>
    <p class="grand-total">
        Init. Paid:
        {{ $order->init_pay }}
        BDT
    </p>

    <p class="totals">
        Due:
        {{ $order->due_amount }}
        BDT
    </p>

    <p class="totals">
        Due Paid:
        {{ $order->due_paid_amount }}
        BDT
    </p>

    <div class="">
        @foreach($order->due_payments as $duePayment)
            <div style="display: flex;">
                <p class="totals">
                    Due Paid Date:
                    {{ $duePayment->due_paid_date ? \Carbon\Carbon::parse($duePayment->due_paid_date)->format('d-m-Y') : 'N/A' }}
                    BDT
                </p>

                 <p class="totals" style="margin-left: 20px;">
                    Due Paid Amount:
                    {{ $duePayment->due_paid_amount }}
                    BDT
                </p>

                <p class="totals">
                    Due Paid Via:
                    {{ $duePayment->due_paid_via ? $duePayment->due_paid_via->name : 'N/A' }}
                </p>

                <p class="totals">
                    Remark on Due Payment:
                    {{ $duePayment->remark ?? 'N/A' }}
                </p>
            </div>
        @endforeach
    </div>



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
