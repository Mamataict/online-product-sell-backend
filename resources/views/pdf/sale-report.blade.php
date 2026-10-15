
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20px 22px 25px 22px;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: solaimanlipi, sans-serif;
            font-size: 11px;
            color: #222222;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table {
            border-bottom: 2px solid #1d5c6b;
            margin-bottom: 12px;
        }

        .header-table td {
            padding: 6px 4px 10px;
            vertical-align: middle;
        }

        .company-name {
            font-size: 21px;
            font-weight: bold;
            color: #1d5c6b;
        }

        .document-title {
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 3px;
        }

        .document-subtitle {
            font-size: 10px;
            color: #555555;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1d5c6b;
            padding: 5px 0;
            border-bottom: 1px solid #cccccc;
            margin-bottom: 5px;
        }

        .info-table {
            margin-bottom: 12px;
        }

        .info-table td {
            width: 50%;
            padding: 4px 6px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #444444;
        }

        .data-table {
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .data-table thead {
            display: table-header-group;
        }

        .data-table th {
            background-color: #1d5c6b;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 7px 5px;
            border: 1px solid #1d5c6b;
        }

        .data-table td {
            padding: 6px 5px;
            border: 1px solid #b8c3c6;
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f5f8f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary-table {
            width: 48%;
            margin-left: auto;
            margin-top: 8px;
            margin-bottom: 10px;
        }

        .summary-table td {
            padding: 4px 7px;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-label {
            text-align: right;
            font-weight: bold;
        }

        .summary-value {
            text-align: right;
            white-space: nowrap;
        }

        .grand-total td {
            font-weight: bold;
            font-size: 12px;
            color: #1d5c6b;
            border-top: 2px solid #1d5c6b;
            border-bottom: 2px solid #1d5c6b;
            padding-top: 7px;
            padding-bottom: 7px;
        }

        .amount-words {
            margin-top: 10px;
            padding: 8px;
            border: 1px solid #cbd5d8;
            background-color: #f7f9fa;
        }

        /*
         * Bottom signature area.
         * Works best for a single-page invoice.
         */
        .bottom-area {
            page-break-inside: avoid;
            margin-top: 55px;
        }

        .signature-table {
            width: 100%;
            margin: 0;
            page-break-inside: avoid;
        }

        .signature-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 10px;
        }

        .signature-line {
            border-top: 1px solid #333333;
            padding-top: 5px;
            margin: 0 auto;
            width: 85%;
        }

        .signature-title {
            font-weight: bold;
            font-size: 11px;
        }

        .signature-subtitle {
            font-size: 9px;
            color: #555555;
        }

        .footer-note {
            text-align: center;
            color: #666666;
            font-size: 9px;
            border-top: 1px solid #cccccc;
            padding-top: 5px;
            margin-top: 18px;
        }

        .currency {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    {{-- Company Header --}}
    <table class="header-table">
        <tr>
            <td width="20%" align="left">
                <img
                    src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}"
                    width="65"
                    height="65"
                    alt="Dairy Fresh Logo"
                >
            </td>

            <td width="60%" align="center">
                <div class="company-name">Dairy Fresh</div>
                <div class="document-title">BILL (Order)</div>
                <div class="document-subtitle">Order Invoice</div>
            </td>

            <td width="20%" align="right">
                <strong>Print Date</strong><br>
                {{ now()->format('d-m-Y') }}
            </td>
        </tr>
    </table>

    {{-- Invoice Information --}}
    <div class="section-title">Invoice Information</div>

    <table class="info-table">
        <tr>
            <td>
                <span class="label">Customer Name:</span>
                {{ $order->customer->name ?? 'N/A' }}
            </td>
            <td>
                <span class="label">Customer Address:</span>
                {{ $order->customer->address ?? 'N/A' }}
            </td>

            <td>
                <span class="label">Invoice No:</span>
                {{ $order->order_info_id ?? 'N/A' }}
            </td>
        </tr>

        <tr>
            <td>
                <span class="label">Mobile:</span>
                {{ $order->customer->phone ?? 'N/A' }}
            </td>

            <td>
                <span class="label">Invoice Date:</span>
                {{ $order->place_date
                    ? \Carbon\Carbon::parse($order->place_date)->format('d-m-Y')
                    : 'N/A' }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="label">Remarks:</span>
                {{ $order->remark ?: 'N/A' }}
            </td>
        </tr>
    </table>

    {{-- Product Details --}}
    <div class="section-title">Product Details</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">SL</th>
                <th width="42%">Product Description</th>
                <th width="14%">Quantity</th>
                <th width="18%">Price (BDT)</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($order->orders as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->product->name ?? 'N/A' }}
                        ({{ $item->product->unit ?? '' }})
                    </td>

                    <td class="text-center">
                        {{ $item->qty ?? 0 }}
                    </td>

                    <td class="text-right">
                        {{ number_format((float) ($item->total_item_price ?? 0), 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No product details available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Payment Summary --}}
    <div class="section-title">Payment Summary</div>

    <table class="summary-table">
        <tr>
            <td class="summary-label">Total:</td>
            <td class="summary-value">
                {{ number_format((float) ($order->grand_total ?? 0), 2) }} BDT
            </td>
        </tr>

        <tr>
            <td class="summary-label">Delivery Fee:</td>
            <td class="summary-value">
                {{ number_format((float) ($order->delivery_fee ?? 0), 2) }} BDT
            </td>
        </tr>

        <tr class="grand-total">
            <td class="summary-label">Paid Amount:</td>
            <td class="summary-value">
                {{ number_format((float) ($order->total_paid ?? 0), 2) }} BDT
            </td>
        </tr>

        <tr>
            <td class="summary-label">Due Amount:</td>
            <td class="summary-value">
                {{ number_format((float) ($order->due_amount ?? 0), 2) }} BDT
            </td>
        </tr>
    </table>

    <div class="bottom-area">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-line">Prepared By</div>
                </td>

                <td>
                    <div class="signature-line">Delivered By</div>
                </td>

                <td>
                    <div class="signature-line">Received By</div>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            Dairy Fresh | Order Invoice
        </div>
    </div>

</body>
</html>
