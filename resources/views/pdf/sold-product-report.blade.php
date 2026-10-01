<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Sale Report</title>

    <style>
        @page {
    margin-top: 28px;
    margin-left: 15px;
    margin-right: 15px;
    margin-bottom: 110px;
    margin-footer: 15px;
    footer: html_signoff;
}

        body {
            font-family: solaimanlipi;
            font-size: 12px;
            color: #1a1a1a;
        }

        /* Header */
        .meta-row {
            text-align: right;
            font-size: 10px;
            color: #555555;
            margin-bottom: 8px;
        }

        .letterhead {
            text-align: center;
        }

        .company-name {
            font-size: 19px;
            font-weight: bold;
            margin-top: 5px;
        }

        .doc-title {
            margin: 10px 100px 0 100px;
            padding: 4px 10px;
            border-top: 1px solid #1d5c6b;
            border-bottom: 1px solid #1d5c6b;
            font-weight: bold;
            font-size: 12px;
            color: #1d5c6b;
            text-align: center;
        }

        .date-range {
            text-align: center;
            margin-top: 6px;
            font-size: 11px;
        }

        hr {
            height: 1px;
            color: #999999;
            margin: 12px 0 9px 0;
        }

        /* Table */
        .custom_table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 7px;
            font-size: 9.5px;
        }

        .custom_table th {
            background-color: #1d5c6b;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #174b57;
        }

        .custom_table td {
            padding: 5px 4px;
            border: 1px solid #cfd7d9;
            vertical-align: middle;
        }

        .custom_table .center { text-align: center; }
        .custom_table .num { text-align: right; white-space: nowrap; }

        .row-alt td { background-color: #f7f9fa; }

        .customer-phone {
            font-size: 8.5px;
            color: #666666;
        }

        .totals-row td {
            background-color: #e8f1f3;
            border-top: 2px solid #1d5c6b;
            font-weight: bold;
            color: #173f49;
        }

        .empty-row td {
            text-align: center;
            color: #777777;
            padding: 12px 2px;
        }

        /* Footer */
        .signoff {
            width: 100%;
            border-collapse: collapse;
        }

        .signoff td {
            width: 33%;
            text-align: center;
            font-size: 11px;
            padding: 30px 18px 0 18px;
        }

        .sig-line {
            border-top: 1px solid #1a1a1a;
            padding-top: 4px;
        }
    </style>
</head>

<body>

    {{-- Repeats on every page --}}
    <htmlpagefooter name="signoff">
        <table class="signoff">
            <tr>
                <td><div class="sig-line">Prepared By</div></td>
                <td><div class="sig-line">Delivered By</div></td>
                <td><div class="sig-line">Received By</div></td>
            </tr>
        </table>
    </htmlpagefooter>
 

    <div class="meta-row">
        Print Date: {{ now()->format('d-m-Y') }}
    </div>

    <div class="letterhead">
        <img src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}" width="58" height="58" alt="Dairy Fresh">

        <div class="company-name">Dairy Fresh</div>

        <div class="doc-title">
            BILL &middot; PRODUCT ORDER
            ({{ $product_info?->name }}@if ($product_info?->name && $product_info?->unit) - @endif{{ $product_info?->unit }})
        </div>
    </div>

    <div class="date-range">
        Date: {{ $start_date }} to {{ $end_date }}
    </div>

    <hr>

    <table class="custom_table">
        <thead>
            <tr>
                <th width="5%">SL.</th>
                <th width="11%">Date</th>
                <th width="11%">Invoice</th>
                <th width="12%">Payment Status</th>
                <th width="24%">Customer</th>
                <th width="9%">Qty</th>
                <th width="12%">Amount</th>
                <th width="16%">Remark</th>
            </tr>
        </thead>

        <tbody>
            @if ($products->count() > 0)

                @foreach ($products as $product)
                    <tr class="{{ $loop->even ? 'row-alt' : '' }}">
                        <td class="center">{{ $loop->iteration }}</td>

                        <td class="center">
                            @if ($product->order_info?->place_date)
                                {{ \Carbon\Carbon::parse($product->order_info->place_date)->format('d-m-Y') }}
                            @endif
                        </td>

                        <td class="center">{{ $product->order_info?->order_info_id }}</td>

                        <td class="center">{{ $product->order_info?->payment_status_text }}</td>

                        <td class="center">
                            {{ $product->order_info?->customer?->name }}
                            @if ($product->order_info?->customer?->phone)
                                <br>
                                <span class="customer-phone">({{ $product->order_info->customer->phone }})</span>
                            @endif
                        </td>

                        <td class="num">{{ number_format($product->qty, 2) }}</td>

                        <td class="num">{{ number_format($product->total_item_price, 2) }}</td>

                        <td>{{ $product->order_info?->remark }}</td>
                    </tr>
                @endforeach
                

                <tr class="totals-row">
                    <td colspan="5" class="num">Total</td>
                    <td class="num">{{ number_format($total_qty, 2) }}</td>
                    <td class="num">{{ number_format($total_price, 2) }}</td>
                    <td></td>
                </tr>
            @else
                <tr class="empty-row">
                    <td colspan="8">No products found.</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>