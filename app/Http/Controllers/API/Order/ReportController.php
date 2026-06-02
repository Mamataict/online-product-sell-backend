<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
        $products = OrderDetails::with(['productPrice.product', 'order_info.branch', 'order_info.customer', 'order_info.seller'])
                ->whereHas('order_info', function ($query) {
                    $query->where('payment_status', 'completed');
                })
                ->when(request()->filled('search'), function ($query) {
                    $query->whereHas('order_info', function ($q) {
                        $q->where('invoice', 'like', '%' . request('search') . '%');
                    });
                })
                ->when(request()->filled('product_id'), function ($query) {
                    $query->whereHas('productPrice.product', function ($q) {
                        $q->where('id', request('product_id'));
                    });
                })
                ->when(
                    request()->filled('start_date') &&
                        request()->filled('end_date'),

                    function ($q) {

                        $q->whereHas('order_info', function ($q2) {

                            $q2->whereBetween('place_date', [
                                request('start_date'),
                                request('end_date'),
                            ]);
                        });
                    }
                )
                ->latest()
                ->get()
                ;

        $pdf = Pdf::loadView('pdf.sold-product-report', compact('products'))
            ->setPaper([0, 0, 380, 600]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="sold-product-report.pdf"',
        ]);
    }
}
