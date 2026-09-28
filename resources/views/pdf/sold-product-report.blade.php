```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Product Sale Report</title>

    <style>
        /*
        |--------------------------------------------------------------------------
        | Page Setup
        |--------------------------------------------------------------------------
        */

        @page {
            margin: 28px 15px 130px 15px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Courier New", monospace;
            font-size: 12px;
            color: #1a1a1a;
            margin: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        .meta-row {
            text-align: right;
            font-size: 10px;
            color: #555555;
            margin-bottom: 8px;
        }

        .letterhead {
            text-align: center;
        }

        .letterhead img {
            width: 58px;
            height: 58px;
        }

        .company-name {
            font-size: 19px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }

        .company-tagline {
            font-size: 10px;
            color: #555555;
            margin-top: 2px;
        }

        .doc-title {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 18px;
            border-top: 1px solid #1d5c6b;
            border-bottom: 1px solid #1d5c6b;
            font-weight: bold;
            font-size: 12px;
            color: #1d5c6b;
        }

        .date-range {
            margin-top: 6px;
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 1px dashed #999999;
            margin: 12px 0 9px 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Main Table
        |--------------------------------------------------------------------------
        */

        .custom_table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 7px;
            border: 1px solid #aeb9bc;
            font-size: 9.5px;
        }

        /*
        |--------------------------------------------------------------------------
        | Column Widths
        |--------------------------------------------------------------------------
        |
        | Total = 100%
        |
        */

        /* .custom_table th:nth-child(1),
        .custom_table td:nth-child(1) {
            width: 4%;
        }

        .custom_table th:nth-child(2),
        .custom_table td:nth-child(2) {
            width: 12%;
        }

        .custom_table th:nth-child(3),
        .custom_table td:nth-child(3) {
            width: 9%;
        }

        .custom_table th:nth-child(4),
        .custom_table td:nth-child(4) {
            width: 9%;
        }

        .custom_table th:nth-child(5),
        .custom_table td:nth-child(5) {
            width: 12%;
        }

        .custom_table th:nth-child(6),
        .custom_table td:nth-child(6) {
            width: 24%;
        }

        .custom_table th:nth-child(7),
        .custom_table td:nth-child(7) {
            width: 7%;
        }

        .custom_table th:nth-child(8),
        .custom_table td:nth-child(8) {
            width: 11%;
        }

        .custom_table th:nth-child(9),
        .custom_table td:nth-child(9) {
            width: 15%;
        } */

        /*
        |--------------------------------------------------------------------------
        | Table Header
        |--------------------------------------------------------------------------
        */

        .custom_table thead th {
            background-color: #1d5c6b;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #174b57;
            vertical-align: middle;
            line-height: 1.2;
        }

        /*
        |--------------------------------------------------------------------------
        | Table Body
        |--------------------------------------------------------------------------
        */

        .custom_table tbody td {
            padding: 5px 4px;
            border: 1px solid #cfd7d9;
            vertical-align: middle;
            line-height: 1.25;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /*
        |--------------------------------------------------------------------------
        | Alternating Rows
        |--------------------------------------------------------------------------
        */

        .custom_table tbody tr:nth-child(even) {
            background-color: #f7f9fa;
        }

        /*
        |--------------------------------------------------------------------------
        | Alignment
        |--------------------------------------------------------------------------
        */

        .custom_table .num {
            text-align: right;
            white-space: nowrap;
        }

        .custom_table th:first-child,
        .custom_table td:first-child,
        .custom_table th:nth-child(2),
        .custom_table td:nth-child(2),
        .custom_table th:nth-child(3),
        .custom_table td:nth-child(3),
        .custom_table th:nth-child(4),
        .custom_table td:nth-child(4),
        .custom_table th:nth-child(5),
        .custom_table td:nth-child(5) {
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | Customer Information
        |--------------------------------------------------------------------------
        */

        .customer-phone {
            font-size: 8.5px;
            color: #666666;
        }

        /*
        |--------------------------------------------------------------------------
        | Total Row
        |--------------------------------------------------------------------------
        */

        .custom_table .totals-row td {
            background-color: #e8f1f3;
            border-top: 2px solid #1d5c6b;
            border-bottom: 1px solid #1d5c6b;
            padding: 6px 4px;
            font-weight: bold;
            color: #173f49;
        }

        .custom_table .totals-row td:first-child {
            text-align: right;
        }

        /*
        |--------------------------------------------------------------------------
        | Empty Row
        |--------------------------------------------------------------------------
        */

        .custom_table .empty-row td {
            text-align: center;
            color: #777777;
            padding: 18px 4px;
            background-color: #fafafa;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer / Signature
        |--------------------------------------------------------------------------
        */

        .footer-signoff {
            position: fixed;
            bottom: -110px;
            left: 0;
            right: 0;
        }

        .footer-signoff table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-signoff td {
            width: 33.33%;
            text-align: center;
            padding-top: 34px;
            font-size: 11px;
        }

        .footer-signoff .sig-line {
            display: block;
            border-top: 1px solid #1a1a1a;
            margin: 0 18px 4px 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent table rows from splitting where possible
        |--------------------------------------------------------------------------
        */

        .custom_table tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- Print Date --}}
    <div class="meta-row">
        Print Date: {{ now()->format('d-m-Y') }}
    </div>


    {{-- Letterhead --}}
    <div class="letterhead">

        <img
            src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}"
            alt="Dairy Fresh"
        >

        <div class="company-name">
            Dairy Fresh
        </div>

        <div class="company-tagline">
            {{-- Address / Phone / Email --}}
        </div>

        <div class="doc-title">
            BILL &middot; PRODUCT ORDER (

            {{ $product_info?->name }}

            @if ($product_info?->name && $product_info?->unit)
                -
            @endif

            {{ $product_info?->unit }}

            )
        </div>

    </div>


    {{-- Date Range --}}
    <div class="date-range">
        Date: {{ $start_date }} to {{ $end_date }}
    </div>


    <hr>


    {{-- Product Sale Table --}}
    <table class="custom_table">

        <thead>
            <tr>
                <th>SL.</th>
                <th>Date</th>
                <th>Invoice</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Customer</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Remark</th>
            </tr>
        </thead>

        <tbody>

            @if ($products->count() > 0)

                @foreach ($products as $product)

                    <tr>

                        {{-- SL --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- Date --}}
                        <td>
                            @if ($product->order_info?->place_date)
                                {{ \Carbon\Carbon::parse($product->order_info->place_date)->format('d-m-Y') }}
                            @endif
                        </td>


                        {{-- Invoice --}}
                        <td>
                            {{ $product->order_info?->order_info_id }}
                        </td>


                        {{-- Status --}}
                        <td>
                            {{ $product->order_info?->status_text }}
                        </td>


                        {{-- Payment Status --}}
                        <td>
                            {{ $product->order_info?->payment_status_text }}
                        </td>


                        {{-- Customer --}}
                        <td>
                            {{ $product->order_info?->customer?->name }}

                            @if ($product->order_info?->customer?->phone)
                                <br>

                                <span class="customer-phone">
                                    ({{ $product->order_info->customer->phone }})
                                </span>
                            @endif
                        </td>


                        {{-- Quantity --}}
                        <td class="num">
                            {{ number_format($product->qty, 2) }}
                        </td>


                        {{-- Amount --}}
                        <td class="num">
                            {{ number_format($product->total_item_price, 2) }}
                        </td>


                        {{-- Remark --}}
                        <td>
                            {{ $product->order_info?->remark }}
                        </td>

                    </tr>

                @endforeach


                {{-- Total --}}
                <tr class="totals-row">

                    <td colspan="6" class="num">
                        Total
                    </td>

                    <td class="num">
                        {{ number_format($total_qty, 2) }}
                    </td>

                    <td class="num">
                        {{ number_format($total_price, 2) }}
                    </td>

                    <td></td>

                </tr>

            @else

                {{-- Empty --}}
                <tr class="empty-row">

                    <td colspan="9">
                        No products found.
                    </td>

                </tr>

            @endif

        </tbody>

    </table>


    {{-- Signature Section --}}
    <div class="footer-signoff">

        <table>

            <tr>

                <td>
                    <span class="sig-line"></span>
                    Prepared By
                </td>

                <td>
                    <span class="sig-line"></span>
                    Delivered By
                </td>

                <td>
                    <span class="sig-line"></span>
                    Received By
                </td>

            </tr>

        </table>

    </div>

</body>

</html>