
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin-top: 28px;
            margin-left: 15px;
            margin-right: 15px;
            margin-bottom: 100px;
            footer: html_signoff;
        }

        body {
            font-family: solaimanlipi;
            font-size: 10px;
            line-height: 1.4;
            color: #263238;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        /* Header */
        .print-date {
            text-align: right;
            font-size: 9px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .logo {
            text-align: center;
            margin-bottom: 3px;
        }

        .company-name {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #1d5c6b;
            letter-spacing: 1px;
        }

        .report-subtitle {
            text-align: center;
            font-size: 9px;
            color: #475569;
            margin-top: 2px;
        }

        .report-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
            background-color: #1d5c6b;
            padding: 7px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Report information */
        .report-summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .report-summary td {
            border: 1px solid #d8e2e5;
            padding: 6px 8px;
            font-size: 10px;
        }

        .report-summary .label {
            background-color: #edf4f5;
            color: #1d5c6b;
            font-weight: bold;
        }

        /* Orders table */
        .data_table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 5px;
        }

        .data_table thead {
            display: table-header-group;
        }

        .data_table th {
            background-color: #1d5c6b;
            color: #ffffff;
            border: 1px solid #174a56;
            padding: 7px 3px;
            font-size: 9px;
            text-align: center;
            font-weight: bold;
        }

        .data_table td {
            border: 1px solid #d5dfe2;
            padding: 6px 4px;
            font-size: 9px;
            word-wrap: break-word;
            vertical-align: middle;
        }

        .data_table tbody tr:nth-child(even) {
            background-color: #f1f7f8;
        }

        .data_table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .data_table .number {
            text-align: right;
        }

        .data_table .total-row td {
            background-color: #e1eff1;
            color: #174a56;
            font-weight: bold;
            border-top: 2px solid #1d5c6b;
            padding: 8px 4px;
        }

        .empty-row {
            text-align: center;
            padding: 15px !important;
            color: #64748b;
        }

        tr {
            page-break-inside: avoid;
        }

        /* Official signature footer */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .signature-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 12px;
            font-size: 9px;
        }

        .signature-space {
            height: 34px;
        }

        .signature-line {
            border-top: 1px solid #263238;
            padding-top: 5px;
            font-weight: bold;
            color: #1d5c6b;
        }

        .signature-designation {
            font-size: 8px;
            color: #475569;
            margin-top: 3px;
        }

        .signature-date {
            font-size: 8px;
            color: #475569;
            margin-top: 6px;
        }

        .footer-note {
            border-top: 1px solid #d8e2e5;
            margin-top: 9px;
            padding-top: 4px;
            text-align: center;
            color: #64748b;
            font-size: 8px;
        }
    </style>
</head>

<body>

    <div class="print-date">
        Print Date: {{ now()->format('d-m-Y h:i A') }}
    </div>

    <div class="logo">
        <img
            src="{{ public_path('images_cus/icons/dairy_fresh_logo.png') }}"
            width="48"
            height="48"
            alt="Dairy Fresh Logo"
        >
    </div>

    <div class="company-name">
        Dairy Fresh
    </div>

    <div class="report-subtitle">
        Due Report
    </div>

    <div class="report-title">
        BILL (Due) REPORT
    </div>

    <table class="report-summary">
        <tr>
            <td class="label" width="18%">
                Report Date
            </td>
            <td width="32%">
                {{ now()->format('d-m-Y') }}
            </td>

            <td class="label" width="18%">
                Total Orders
            </td>
            <td width="32%">
                {{ $orders->count() }}
            </td>
        </tr>
    </table>
    <table class="report-summary">
        <tr>
            <td class="label" width="18%">
                Order Status
            </td>
            <td width="82%">
                {{ $orders->first()->status_text }}
            </td>
        </tr>
    </table>

    <table class="data_table">
        <thead>
            <tr>
                <th width="6%">SL.</th>
                <th width="13%">Date</th>
                <th width="14%">Invoice</th>
                <th width="23%">Customer</th>
                <th width="15%">Due Paid</th>
                <th width="14%">Due remaining</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $item)
                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->place_date
                    ? \Carbon\Carbon::parse($item->place_date)->format('d-m-Y')
                    : 'N/A' }}
                    </td>

                    <td>
                        {{ $item->order_info_id ?? 'N/A' }}
                    </td>

                    <td>
                        {{ $item->customer->name ?? 'N/A' }} ({{$item->customer->phone}})
                    </td>

                    <td class="number">
                        {{ number_format((float) ($item->due_paid_amount ?? 0), 2) }}
                    </td>

                    <td class="number">
                        {{ number_format((float) ($item->due_amount ?? 0), 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-row">
                        No sales data available.
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="right">
                    Grand Total:
                </td>

                <td class="number">
                    {{ number_format((float) ($total_due_paid ?? 0), 2) }}
                </td>

                <td class="number">
                    {{ number_format((float) ($total_due_remaining ?? 0), 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <htmlpagefooter name="signoff">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-space"></div>

                    <div class="signature-line">
                        Prepared By
                    </div>

                </td>

                <td>
                    <div class="signature-space"></div>

                    <div class="signature-line">
                        Checked By
                    </div>

                </td>

                <td>
                    <div class="signature-space"></div>

                    <div class="signature-line">
                        Approved By
                    </div>

                </td>
            </tr>
        </table>

        <div class="footer-note">
            Dairy Fresh | Orders Report
        </div>
    </htmlpagefooter>

    <sethtmlpagefooter name="signoff" value="on" />

</body>
</html>
