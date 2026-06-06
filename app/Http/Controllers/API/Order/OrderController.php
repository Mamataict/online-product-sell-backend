<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DuePayRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Branch\BranchInfo;
use App\Models\Campaign\CampaignDetails;
use App\Models\Campaign\CampaignInfo;
use App\Models\Order\Adjustment;
use App\Models\Order\Cart;
use App\Models\Order\CartDetails;
use App\Models\Order\Customer;
use App\Models\Order\DuePayment;
use App\Models\Order\OrderDetails;
use App\Models\Order\OrderInfo;
use App\Models\PaymentInfo\PaymentVia;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductInfo;
use App\Models\Product\ProductPrices;
use App\Traits\ProductInfoCheck;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

use function Symfony\Component\Clock\now;

class OrderController extends Controller
{

    use ProductInfoCheck;

    public function __construct()
    {
        $this->middleware('check_permission:order.index')->only(['index']);
        $this->middleware('check_permission:order.show')->only(['show']);
        $this->middleware('check_permission:order.cancel')->only(['cancelOrder']);
        $this->middleware('check_permission:order.print')->only(['printSlip']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $request = request();

            $orders = OrderInfo::with('customer', 'handler', 'remarker')

                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereBetween('place_date', [
                        $request->start_date,
                        $request->end_date,
                    ]);
                })

                ->when($request->filled('order_id'), function ($query) use ($request) {
                    $query->where('order_info_id', 'like', "%{$request->order_id}%");
                })

                ->when($request->filled('cus_phone'), function ($query) use ($request) {
                    $query->whereHas('customer', function ($q) use ($request) {
                        $q->where('phone', 'like', "%{$request->cus_phone}%");
                    });
                })

                ->when($request->filled('order_status'), function ($query) use ($request) {
                    $query->where('status', 'like', "%{$request->order_status}%");
                })

                ->orderByDesc('created_at')

                ->paginate();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' =>
                [
                    'orders' => $orders,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function orderInfos()
    {
        try {
            $order_count = OrderInfo::when(request()->get('type') == '30Days', function ($query) {
                $query->whereDate('place_date', '>=', Carbon::now()->subDays(30));
            })
                ->whereNot('payment_status', 'pending')->count();
            $order_income = OrderInfo::where('payment_status', 'completed')->sum('grand_total');
            $customer_count = Customer::where('is_active', 1)->count();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'order_count' => $order_count,
                    'order_income' => $order_income,
                    'customer_count' => $customer_count,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    private function orderInfo($id)
    {
        return OrderInfo::with(['orders.productPrice.product', 'orders.adjustment.creator', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via', 'due_payments'])
            ->find($id);
    }

    // public function create()
    // {
    //     try {

    //         $order = null;

    //         if (request('order_type') == 'edit') {
    //             $order = OrderInfo::where('place_date', '>=', Carbon::now()->subDay(1))
    //                 ->where('id', request('order_id'))
    //                 ->first();
    //         } else {

    //             if (empty(request('order_id'))) {

    //                 $order = OrderInfo::create([
    //                     'invoice' => 'Not Available',
    //                     'payable_price' => 0,
    //                     'sales_person' => auth()->guard('api')->user()->id,
    //                     'branch_info_id' => auth()->guard('api')->user()->branches->first()->id,
    //                     'payment_status' => 'pending',
    //                 ]);
    //             } else {

    //                 $order = OrderInfo::when(!empty(request('order_id')), function ($query) {
    //                     $query->where('id', request('order_id'));
    //                 })
    //                     ->where('branch_info_id', auth()->guard('api')->user()->branches->first()->id)
    //                     ->where('sales_person', auth()->guard('api')->user()->id)
    //                     ->where('payment_status', 'pending')
    //                     ->first();

    //                 $order->sales_person = auth()->guard('api')->user()->id;
    //                 $order->branch_info_id = auth()->guard('api')->user()->branches->first()->id;
    //                 $order->save();
    //             }
    //         }

    //         $order_info = $this->orderInfo($order->id);

    //         $product_categories = ProductCategory::where('is_active', 1)->get();

    //         $campaigns = CampaignDetails::with('campaign')
    //             ->where(function ($query) {
    //                 $query->whereHas('branches.users', function ($q) {
    //                     $q->where('users.id', auth()->guard('api')->id());
    //                 })
    //                     ->orWhereDoesntHave('branches');
    //             })
    //             ->whereDate('effect_date', '<=', now())
    //             ->active()
    //             ->get();

    //         $payment_via = PaymentVia::where('is_active', 1)->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Data retrieved successfully.',
    //             'data' => [
    //                 'order' => $order_info,
    //                 'product_categories' => $product_categories,
    //                 'campaigns' => $campaigns,
    //                 'payment_via' => $payment_via,
    //             ],
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'Something went wrong',
    //         ], 500);
    //     }
    // }

    public function getProductsBySearch()
    {
        try {
            $products = ProductPrices::with('product')
                ->whereIn('id', function ($query) {
                    $query->selectRaw('MAX(product_prices.id)')
                        ->from('product_prices')
                        ->join('product_infos', 'product_infos.id', '=', 'product_prices.product_info_id')
                        ->whereDate('product_prices.effect_date', '<=', now())
                        ->where('product_prices.is_active', 1)
                        ->where('product_infos.is_active', 1)
                        ->when(request('search'), function ($q) {
                            $q->where(function ($q2) {
                                $q2->where('product_infos.product_id', 'like', '%' . request('search') . '%')
                                    ->orWhere('product_infos.name', 'like', '%' . request('search') . '%');
                            });
                        })
                        ->when(request('product_id'), function ($query) {
                            return $query->where('product_info_id', request('product_id'));
                        })
                        ->groupBy('product_prices.product_info_id');
                })
                ->whereHas('branches', function ($query) {
                    $query->whereIn(
                        'branch_infos.id',
                        auth()->guard('api')->user()->branches->pluck('id')
                    )->where('is_active', 1);
                })

                ->get();


            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $products,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function orderDetails($id)
    {
        try {
            $order = OrderInfo::with(['orders.product', 'customer', 'handler'])
                ->where('order_info_id', $id)
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }
    public function details($id)
    {
        try {
            $order = OrderInfo::with(['orders.product', 'customer', 'handler', 'remarker'])
                ->where('id', $id)
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // try {

        //     session([
        //         'user_name' => $request->name,
        //     ]);

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Data retrieved successfully.',
        //         'data' => [
        //             'session' => session('user_name')
        //         ],
        //     ]);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'status' => 'Something went wrong',
        //     ], 500);
        // }
    }

    public function orderConfirm(Request $request)
    {
        try {

            $order_id = OrderInfo::generateOrderId();

            $customer = Customer::create(
                [
                    'name' => $request->customer['name'],
                    'phone' => $request->customer['phone'],
                    'address' => $request->customer['address'],
                ]
            );

            $order_info = OrderInfo::create([
                'order_info_id' => $order_id,
                'customer_id' => $customer->id,
                'delivery_fee' => $request->shipping_cost,
                'status' => 1,
                'place_date' => Carbon::now()->format('Y-m-d'),
            ]);

            $sub_total = 0;

            foreach ($request->products as $product) {

                $product_price = ProductInfo::find($product['product_id'])->latest_price->price;
                OrderDetails::create([
                    'order_id' => $order_info->id,
                    'product_info_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'price' => $product_price,
                ]);

                $sub_total += $product_price * $product['qty'];
            }

            $order_info->subtotal = $sub_total;
            $order_info->grand_total = $sub_total + $request->shipping_cost;
            $order_info->save();

            return response()->json([
                'status' => true,
                'route' => $order_info->order_info_id,
                'message' => 'অর্ডারটি সম্পন্ন হয়েছে, আমরা আপনার সাথে যোগাযোগ করবো খুব শীঘ্রই',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
            ], 500);
        }
    }

    public function orderStatus($id)
    {
        try {

            $order = OrderInfo::find($id);

            $order->status = request('status');
            $order->remark = request('remark');
            $order->handler_id = Auth::guard('api')->id();

            $order->save();

            return response()->json([
                'status' => true,
                'message' => 'Order status changed successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }
    public function orderRemark($id)
    {
        try {

            $order = OrderInfo::find($id);
            $order->remark = request('remark');
            $order->remark_by = Auth::guard('api')->id();

            $order->save();

            return response()->json([
                'status' => true,
                'message' => 'Order remark updated successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function orderStore(Request $request)
    {
        try {

            $cart = Cart::where('guest_id', $request->session_id)->first();

            if (empty($cart)) {
                $cart = Cart::create(
                    [
                        'guest_id' => $request->session_id
                    ]
                );
            }

            $cart_details = $cart->cart_details()->where('product_info_id', $request->product_id)->first();

            if (empty($cart_details)) {
                $cart_details = CartDetails::create([
                    'cart_id' => $cart->id,
                    'product_info_id' => $request->product_id,
                    'qty' => $request->qty,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function paymentTypeStore(Request $request)
    {
        try {
            $order_info = OrderInfo::where('payment_status', 'pending')->where('id', $request->order_id_cus)
                ->first();

            if (!empty($order_info)) {
                $order_info->payment_via_id = !empty($request->cus_payment_type_id) ? $request->cus_payment_type_id : null;
                $order_info->save();

                $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                    ->find($order_info->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Data retrieved successfully.',
                    'data' => $order,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function campaignStore(Request $request)
    {
        // try {
        //     $order_info = OrderInfo::find($request->order_id_cus);

        //     if (!empty($request->campaign_id) && !empty($request->order_id_cus) && $order_info->payment_status == 'pending') {
        //         $campaign_details = CampaignDetails::where('id', $request->campaign_id)->whereDate('effect_date', '<=', now())->where('is_active', 1)->first();

        //         if ($campaign_details->discount_type == 'percentage') {
        //             $payable_price = ((100 - $campaign_details->discount) * $order_info->payable_price) / 100;
        //         } else if ($campaign_details->discount_type == 'fixed') {
        //             $payable_price = $order_info->payable_price - $campaign_details->discount;
        //         }

        //         $order_info->payable_price = $payable_price;

        //         $order_info->init_pay = $payable_price;

        //         $order_info->campaign_details_id = $campaign_details->id;
        //         $order_info->save();

        //         $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
        //             ->find($order_info->id);

        //         return response()->json([
        //             'status' => true,
        //             'message' => 'Data retrieved successfully.',
        //             'data' => $order,
        //         ]);
        //     }
        // } catch (Exception $e) {
        //     return response()->json([
        //         'status' => 'Something went wrong',
        //     ], 500);
        // }
    }

    public function campaignRemove(Request $request)
    {
        try {
            $order = OrderInfo::find($request->order_id);

            if (!empty($request->order_id) && $order->payment_status == 'pending') {

                $order = OrderInfo::find($request->order_id);
                $order->campaign_details_id = null;

                $order->save();

                $this->amountSet($request->order_id);

                $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                    ->find($request->order_id);

                return response()->json([
                    'status' => true,
                    'message' => 'Campaign removed successfully.',
                    'data' => $order,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function productQtyChange(Request $request)
    {
        try {

            $order = OrderDetails::find($request->order_details_id);

            $order_id = $order->order_id;

            if ($order->order_info->payment_status == 'pending') {

                $order->adjustment()->delete();

                $order->qty = $request->qty;
                $order->price = $order->productPrice->price * $request->qty;
                $order->discount = $order->productPrice->discount_type == 'percentage' ? (($order->productPrice->price * $order->productPrice->discount) / 100) * $request->qty : $order->productPrice->discount * $request->qty;
                $order->save();
            }

            $this->amountSet($order_id);

            $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                ->find($order_id);

            return response()->json([
                'status' => true,
                'message' => 'Product qty added successfully.',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function itemRemove(Request $request)
    {
        try {

            $order_details_info = OrderDetails::find($request->order_id);

            $order_id = $order_details_info->order_id;

            $is_delete = false;

            if ($order_details_info->order_info->payment_status == 'pending') {

                $is_delete = $order_details_info->delete();
            }

            $order_info = OrderInfo::find($order_id);

            if (!empty($order_info->orders)) {
                $this->amountSet($order_info->id);
            } else if (empty($order_info->orders) && $is_delete) {
                $order_info->payable_price = 0;
                $order_info->init_pay = 0;
                $order_info->due = 0;
                $order_info->campaign_details_id = null;
                $order_info->branch_info_id = null;
                $order_info->sales_person = null;

                $order_info->save();
            }

            $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                ->find($order_id);

            return response()->json([
                'status' => $is_delete,
                'message' => $is_delete ? 'Order item removed successfully.' : 'Order invalid!',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    private function amountSet($order_id)
    {
        $order_info = OrderInfo::find($order_id);

        $grand_total = 0;

        foreach ($order_info->orders as $order) {
            $grand_total += $order->price;
        }

        if (!empty($order_info->campaign_details_id)) {
            if ($order_info->campaign->discount_type == 'percentage') {
                $grand_total = ((100 - $order_info->campaign->discount) * $grand_total) / 100;
            } else if ($order_info->campaign->discount_type == 'fixed') {
                $grand_total = $grand_total - $order_info->campaign->discount;
            }
        }

        $order_info->payable_price = round($grand_total + $order_info->delivery_fee);

        $order_info->init_pay = $order_info->payable_price;

        $order_info->save();
    }

    public function orderPlace(Request $request)
    {
        try {

            $order_info = OrderInfo::find($request->order_id);

            $customer = Customer::updateOrCreate(
                ['phone' => $request->phone],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                ]
            );

            if (!empty($order_info)) {
                if (!empty($order_info->invoice)) {
                    $invoice = 'INV-' . $order_info->branch->branch_code . '-' .
                        (OrderInfo::where('payment_status', 'completed')
                            ->whereBetween('place_date', [
                                Carbon::now()->startOfMonth(),
                                Carbon::now()->endOfMonth(),
                            ])
                            ->where('branch_info_id', $order_info->branch_info_id)
                            ->count() + 1)
                        . '-' . Carbon::now()->format('dmY');
                    $order_info->invoice = $invoice;
                }
                $order_info->customer_id = $customer->id;
                $order_info->place_date = !empty($request->place_date) ? $request->place_date : Carbon::now()->toDateString();
                $order_info->payment_status = 'completed';
                $order_info->save();

                $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                    ->find($request->order_id);

                return response()->json([
                    'status' => true,
                    'message' => 'Order submitted successfully.',
                    'data' => $order,
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Order invalid!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function getCustomers()
    {

        try {
            $customers = Customer::where('phone', 'like', '%' . request('phone') . '%')->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $customers,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = OrderInfo::with(['orders', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                ->when(!auth()->guard('api')->user()->hasPermission('branches.orders.view'), function ($query) {
                    $query->where('branch_info_id', auth()->guard('api')->user()->branches->first()->id);
                })
                ->where('id', $id)
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $order,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
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

    public function cancelOrder($id)
    {
        try {
            $order = OrderInfo::where('id', $id)
                ->first();

            if (!empty($order) && $order->payment_status == 'completed') {
                $order->payment_status = 'cancelled';
                $order->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Order cancelled successfully.',
                    'data' => [],
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Order cannot be cancelled!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function setPayAmount(Request $request)
    {
        try {
            $order = OrderInfo::where('id', $request->order_id)
                ->first();

            if (!empty($order)) {

                $order->init_pay = $request->pay;
                $order->save();

                $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                    ->find($request->order_id);

                return response()->json([
                    'status' => true,
                    'message' => 'Pay amount set successfully.',
                    'data' => $order,
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Pay amount cannot be set!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }
    public function setDeliveryFee(Request $request)
    {
        try {
            $order = OrderInfo::where('id', $request->order_id)
                ->first();

            if (!empty($order)) {

                $order->delivery_fee = $request->delivery_fee;

                $order->save();

                $this->amountSet($request->order_id);

                $order = OrderInfo::with(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller', 'payment_via'])
                    ->find($request->order_id);

                return response()->json([
                    'status' => true,
                    'message' => 'Delivery fee set successfully.',
                    'data' => $order,
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Delivery fee cannot be set!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function printSlip(OrderInfo $order)
    {
        $order->load(['orders.productPrice.product', 'campaign.campaign', 'branch', 'customer', 'seller']);

        $pdf = Pdf::loadView('pdf.pos-receipt', compact('order'))
            ->setPaper([0, 0, 226.77, 450]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="receipt.pdf"',
        ]);
    }

    public function dueReportPrint(OrderInfo $order)
    {
        $order->load(['orders.productPrice.product', 'campaign.campaign', 'branch.users', 'customer', 'seller']);

        $pdf = Pdf::loadView('pdf.due-report', compact('order'))
            ->setPaper([0, 0, 380, 600]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="due-report.pdf"',
        ]);
    }
    public function saleInvoiceReport(OrderInfo $order)
    {
        $order->load(['orders.productPrice.product', 'campaign.campaign', 'branch.users', 'customer', 'seller']);

        $pdf = Pdf::loadView('pdf.sale-report', compact('order'))
            ->setPaper([0, 0, 380, 600]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="sale-invoice-report.pdf"',
        ]);
    }

    public function soldProduct()
    {
        try {
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
                    $query->whereHas('productPrice', function ($q) {
                        $q->where('product_info_id', request('product_id'));
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
                ->paginate(10);

            $product_categories = ProductCategory::has('products.prices.orders')->where('is_active', 1)->get();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' =>
                [
                    'products' => $products,
                    'product_categories' => $product_categories
                ]

            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function soldProductDetails($id)
    {
        try {
            $order_details = OrderDetails::with('productPrice.product', 'order_info.customer', 'order_info.payment_via', 'order_info.seller', 'order_info.branch')
                ->where('id', $id)
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $order_details,

            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function dueReport()
    {
        try {

            // $orders = DuePayment::with(['order.customer', 'order.branch', 'due_paid_via'])

            //     ->whereHas('order', function ($query) {
            //         $query->when(request()->filled('search'), function ($q) {
            //                 $q->where('invoice', 'like', '%' . request('search') . '%')
            //                 ->whereHas('order.customer', function ($q2) {
            //                     $q2->where('phone', 'like', '%' . request('search') . '%');
            //                 })
            //                 ;
            //             });
            //     })
            //     ->whereDate('due_paid_date', '>=', request('start_date'))
            //     ->whereDate('due_paid_date', '<=', request('end_date'))
            //     ->paginate(10);
            $orders = OrderInfo::with(['customer', 'branch',  'due_payments' => function ($query) {
                $query->whereDate('due_paid_date', '>=', request('start_date'))
                    ->whereDate('due_paid_date', '<=', request('end_date'))
                    ->with('due_paid_via');
            },])
                ->whereHas('due_payments', function ($query) {
                    $query->whereDate('due_paid_date', '>=', request('start_date'))
                        ->whereDate('due_paid_date', '<=', request('end_date'));
                })
                ->when(request()->filled('customer_id'), function ($query) {
                    $query->whereHas('customer', function ($q) {
                        $q->where('id', request('customer_id'));
                    });
                })
                ->where('payment_status', 'completed')
                ->where(function ($query) {
                    $query->when(request()->filled('search'), function ($q) {
                        $q->where('invoice', 'like', '%' . request('search') . '%')
                            ->orWhereHas('customer', function ($q2) {
                                $q2->where('phone', 'like', '%' . request('search') . '%');
                            });
                    });
                })
                ->whereColumn('init_pay', '!=', 'payable_price')
                ->whereDate('place_date', '>=', request('start_date'))
                ->whereDate('place_date', '<=', request('end_date'))
                ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $orders,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function dueInvoice($id)
    {
        try {

            // $order = OrderInfo::with(['orders.productPrice.product', 'customer', 'branch', 'due_payment_via'])
            //     ->where('payment_status', 'completed')
            //     // ->where('due', '>', 0)
            //     ->find($id);

            // $payment_vias = PaymentVia::where('is_active', 1)->get();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Data retrieved successfully.',
            //     'data' => [
            //         'order' => $order,
            //         'payment_vias' => $payment_vias,
            //     ],
            // ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }

    public function duePay(DuePayRequest $request, $id)
    {
        try {

            $order = OrderInfo::find($id);

            $order->due_payments()->updateOrCreate(
                ['due_paid_date' => $request->due_paid_date],
                [
                    'due_paid_amount' => $request->due_paid_amount,
                    'due_paid_date' => $request->due_paid_date,
                    'due_payment_via_id' => $request->payment_method,
                    'remark' => $request->remark,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Due amount paid!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function adjustment(Request $request)
    {
        try {

            $adjustment = Adjustment::where('order_details_id', $request->order_details_id)->first();


            if (!empty($adjustment)) {
                $adjustment->amount = $request->amount;
                $adjustment->type = $request->adjustment_type;
                $adjustment->reason = $request->reason;
                $adjustment->adjustment_date = $request->date;
                $adjustment->created_by = auth()->guard('api')->id();
                $adjustment->save();
            } else {
                $adjustment = Adjustment::create([
                    'order_details_id' => $request->order_details_id,
                    'amount' => $request->amount,
                    'type' => $request->adjustment_type,
                    'reason' => $request->reason,
                    'adjustment_date' => $request->date,
                    'created_by' => auth()->guard('api')->id(),
                ]);
            }

            if ($request->adjustment_type == 'refund') {
                $order_details = OrderDetails::find($request->order_details_id);

                $main_qty = $order_details->qty;

                if ($order_details->adjustment->amount > 0) {
                    $main_qty = $order_details->qty + $order_details->adjustment->amount;
                }

                $order_details->qty = $main_qty - $request->amount;
                $order_details->save();

                $this->amountSet($order_details->order_id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Adjustment done successfully!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
            ], 500);
        }
    }

    public function adjustmentDate(Request $request)
    {
        try {
            $adjustment = Adjustment::where('order_details_id', $request->order_id)->first();

            if (!empty($adjustment)) {
                $adjustment->adjustment_date = $request->adjustment_date;
                $adjustment->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Adjustment date updated successfully!',
                'data' => [],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function getDiscountList()
    {
        try {
            $discounts = OrderInfo::has('campaign')->with(['customer', 'campaign'])->where('payment_status', 'completed')
                ->when(request()->filled('search'), function ($query) {
                    $query->where('invoice', 'like', '%' . request('search') . '%');
                })
                ->whereDate('place_date', '>=', request('start_date'))
                ->whereDate('place_date', '<=', request('end_date'))
                ->latest()->paginate(10);

            $total_discount = $discounts->sum(function ($discount) {
                $campaign_discount = 0;
                if (!empty($discount->campaign)) {
                    if ($discount->campaign->discount_type == 'percentage') {
                        $campaign_discount = ($discount->campaign->discount * $discount->payable_price) / 100;
                    } else {
                        $campaign_discount = $discount->campaign->discount;
                    }
                }
                return $campaign_discount;
            });

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'discounts' => $discounts,
                    'total_discount' => $total_discount,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }
    public function getCustomerDiscountList()
    {
        try {
            $discounts = OrderInfo::has('campaign')->with(['customer', 'campaign'])->where('payment_status', 'completed')
                ->when(request()->filled('search'), function ($query) {
                    $query->where('invoice', 'like', '%' . request('search') . '%');
                })
                ->when(request()->filled('customer_id'), function ($query) {
                    $query->whereHas('customer', function ($q) {
                        $q->where('id', request('customer_id'));
                    });
                })
                ->whereDate('place_date', '>=', request('start_date'))
                ->whereDate('place_date', '<=', request('end_date'))
                ->latest()->paginate(10);

            $total_discount = $discounts->sum(function ($discount) {
                $campaign_discount = 0;
                if (!empty($discount->campaign)) {
                    if ($discount->campaign->discount_type == 'percentage') {
                        $campaign_discount = ($discount->campaign->discount * $discount->payable_price) / 100;
                    } else {
                        $campaign_discount = $discount->campaign->discount;
                    }
                }
                return $campaign_discount;
            });

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => [
                    'discounts' => $discounts,
                    'total_discount' => $total_discount,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong',
            ], 500);
        }
    }

    public function discountReportPrint(OrderInfo $order)
    {
        $order->load(['orders.productPrice.product', 'campaign.campaign', 'branch.users', 'customer', 'seller']);

        $pdf = Pdf::loadView('pdf.due-report', compact('order'))
            ->setPaper([0, 0, 380, 600]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="due-report.pdf"',
        ]);
    }

    public function getCustomersInfo()
    {

        try {
            $customers = Customer::where('phone', 'like', '%' . request('search') . '%')->latest()->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Data retrieved successfully.',
                'data' => $customers,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Something went wrong!',
            ], 500);
        }
    }
}
