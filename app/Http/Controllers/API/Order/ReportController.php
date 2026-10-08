<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderDetails;
use App\Models\Product\ProductInfo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function soldProductInvoice()
    {
        $products = OrderDetails::with(['product', 'order_info', 'order_info.customer', 'order_info.handler'])
            ->whereHas('order_info', function ($q) {
                $q->where('status', 2);
            })
            ->when(request()->filled('product_id'), function ($query) {
                $query->where('product_info_id', request('product_id'));
            })
            ->when(
                request()->filled('start_date') &&
                    request()->filled('end_date'),
                function ($q) {
                    $q->whereHas('order_info', function ($q2) {
                        $q2->whereDate('place_date', '>=', request('start_date'))
                            ->whereDate('place_date', '<=', request('end_date'));
                    });
                }
            )->get();

        $total_qty = $products->sum('qty');

        $total_price = $products->sum('total_item_price');

        $start_date = Carbon::parse(request('start_date'))->format('d/m/Y');
        $end_date = Carbon::parse(request('end_date'))->format('d/m/Y');

        $product_info = request()->filled('product_id')
            ? ProductInfo::find(request('product_id'))
            : null;

        $html = view('pdf.sold-product-report', compact('products', 'total_qty', 'total_price', 'start_date', 'end_date', 'product_info'))->render();

        $tempDir = public_path('assets/fonts');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0775, true);
        }

        $fontDirs = (new ConfigVariables())->getDefaults()['fontDir'];
        $fontData = (new FontVariables())->getDefaults()['fontdata'];

        $solaiman = [
            'R'      => 'SolaimanLipi.ttf',
            'useOTL' => 0xFF, // required for Bengali shaping
        ];

        // Only if you added the bold file
        if (file_exists(public_path('assets/fonts/SolaimanLipi_Bold.ttf'))) {
            $solaiman['B'] = 'SolaimanLipi_Bold.ttf';
        }

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4',
            'tempDir'      => $tempDir,
            'fontDir'      => array_merge($fontDirs, [public_path('assets/fonts')]),
            'fontdata'     => $fontData + ['solaimanlipi' => $solaiman],
            'default_font' => 'solaimanlipi',
        ]);

        $mpdf->WriteHTML($html);

        $content = $mpdf->Output('', Destination::STRING_RETURN);

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="product_sale_report.pdf"',
            'Content-Length'      => strlen($content),
        ]);
        // using mpdf

        // $pdf = Pdf::loadView('pdf.sold-product-report', compact('products', 'total_qty', 'total_price', 'start_date', 'end_date', 'product_info'))
        //     ->setPaper([0, 0, 380, 600]);

        // return response($pdf->output(), 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="sold-product-report.pdf"',
        // ]);
    }
}
