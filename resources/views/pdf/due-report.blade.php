<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bill Due</title>

    <style>
        @page {
            margin-top: 28px;
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 110px;
            margin-footer: 15px;
            footer: html_signoff;
        }

        body {
            font-family: solaimanlipi;
            font-size: 12px;
            color: #1a1a1a;
        }

        .meta-row {
            text-align: right;
            font-size: 10px;
            color: #555;
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
            margin: 10px 100px 0;
            padding: 4px 10px;
            border-top: 1px solid #1d5c6b;
            border-bottom: 1px solid #1d5c6b;
            font-weight: bold;
            font-size: 12px;
            color: #1d5c6b;
            text-align: center;
        }

        .invoice-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 11px;
        }

        .invoice-info td {
            width: 50%;
            padding: 4px 3px;
            vertical-align: top;
        }

        .customer-info {
            margin-top: 5px;
            font-size: 11px;
            line-height: 1.6;
        }

        .section-heading {
            font-size: 11px;
            font-weight: bold;
            color: #1d5c6b;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        hr {
            height: 1px;
            color: #999;
            margin: 12px 0 9px;
        }

        .custom_table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 7px;
            font-size: 9.5px;
        }

        .custom_table th {
            background-color: #1d5c6b;
            color: #fff;
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

        .center {
            text-align: center;
        }

        .num {
            text-align: right;
            white-space: nowrap;
        }

        .row-alt td {
            background-color: #f7f9fa;
        }

        .empty-row td {
            text-align: center;
            color: #777;
            padding: 12px 2px;
        }

        .totals-table {
            width: 80%;
            margin-left: 60%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px 6px;
            font-size: 11px;
            border-bottom: 1px solid #e0e6e8;
        }

        .label {
            text-align: left;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        .grand-total td {
            background-color: #e8f1f3;
            border-top: 2px solid #1d5c6b;
            font-weight: bold;
            color: #173f49;
        }

        .due-row td {
            background-color: #1d5c6b;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #174b57;
        }

        .signoff {
            width: 100%;
            border-collapse: collapse;
        }

        .signoff td {
            width: 33.33%;
            text-align: center;
            font-size: 11px;
            padding: 30px 18px 0;
        }

        .sig-line {
            border-top: 1px solid #1a1a1a;
            padding-top: 4px;
        }

        @media print {
            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>

    <htmlpagefooter name="signoff">
        <table class="signoff">
            <tr>
                <td>
                    <div class="sig-line">Prepared By</div>
                </td>
                <td>
                    <div class="sig-line">Delivered By</div>
                </td>
                <td>
                    <div class="sig-line">Received By</div>
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <div class="meta-row">
        Print Date: {{ now()->format('d-m-Y') }}
    </div>

    <div class="letterhead">
        <img src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}" width="58" height="58"
            alt="Dairy Fresh">

        <div class="company-name">Dairy Fresh</div>

        <div class="doc-title">
            BILL &middot; DUE INVOICE
        </div>
    </div>

    <table class="invoice-info">
        <tr>
            <td>
                <strong>Invoice:</strong>
                {{ $order->order_info_id ?? 'N/A' }} 
            </td>

            <td style="text-align: right;">
                <strong>Invoice Date:</strong>
                {{ $order->place_date ? \Carbon\Carbon::parse($order->place_date)->format('d-m-Y') : 'N/A' }}
            </td>
        </tr>
    </table>

    <div style="padding: 10px 0px 6px 0px;">
        <b>Order Status:</b> {{ $order->status_text }}
    </div>

    <div class="customer-info">
        <strong>Customer:</strong>
        {{ $order->customer?->name ?? 'N/A' }}

        @if ($order->customer?->phone)
            &nbsp; | &nbsp;
            <strong>Phone:</strong>
            {{ $order->customer->phone }}
        @endif

        <br>

        <strong>Address:</strong>
        {{ $order->customer?->address ?? 'N/A' }}

        <br>

        <strong>Remark:</strong>
        {{ $order->remark ?? 'N/A' }}
    </div>

    <hr>

    <div class="section-heading">ORDER DETAILS</div>

    <table class="custom_table">
        <thead>
            <tr>
                <th width="8%">SL.</th>
                <th width="46%">Item</th>
                <th width="18%">Qty</th>
                <th width="28%">Price (BDT)</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($order->orders as $item)
                <tr class="{{ $loop->even ? 'row-alt' : '' }}">
                    <td class="center">{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->product?->name ?? 'N/A' }} ({{ $item->product?->unit }})
                    </td>

                    <td class="num">
                        {{ number_format((float) ($item->qty ?? 0), 2) }}
                    </td>

                    <td class="num">
                        {{ number_format((float) ($item->total_item_price ?? 0), 2) }}
                    </td>
                </tr>
            @empty
                <tr class="empty-row">
                    <td colspan="4">No items available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="totals-table">
        <tbody>
            <tr>
                <td class="label">Sub Total</td>
                <td class="amount">
                    {{ number_format((float) ($order->subtotal ?? 0), 2) }}
                </td>
            </tr>

            <tr>
                <td class="label">Delivery Fee</td>
                <td class="amount">
                    {{ number_format((float) ($order->delivery_fee ?? 0), 2) }}
                </td>
            </tr>

            <tr class="grand-total">
                <td class="label">Grand Total</td>
                <td class="amount">
                    {{ number_format((float) ($order->grand_total ?? 0), 2) }}
                </td>
            </tr>

            <tr>
                <td class="label">Paid</td>
                <td class="amount">
                    {{ number_format((float) ($order->total_paid ?? 0), 2) }}
                </td>
            </tr>

            <tr class="due-row">
                <td class="label">Due Amount</td>
                <td class="amount">
                    {{ number_format((float) ($order->due_amount ?? 0), 2) }}
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
