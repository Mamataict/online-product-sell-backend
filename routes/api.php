<?php

use App\Http\Controllers\API\AssetsCus\AchievementController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Authorization\Assets\PermissionController;
use App\Http\Controllers\API\Authorization\Assets\RoleController;
use App\Http\Controllers\API\Authorization\AuthorizationController;
use App\Http\Controllers\API\Branch\BranchController;
use App\Http\Controllers\API\Branch\StoreController;
use App\Http\Controllers\API\Campaign\CampaignDetailsController;
use App\Http\Controllers\API\Campaign\CampaignInfoController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\Order\OrderController;
use App\Http\Controllers\API\Order\ReportController;
use App\Http\Controllers\API\PaymentInfo\PaymentTypeController;
use App\Http\Controllers\API\PaymentInfo\PaymentViaController;
use App\Http\Controllers\API\Product\ProductCategoryController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\Product\SupplierController;
use App\Http\Controllers\API\Team\TeamMemberController;
use App\Http\Controllers\API\Team\TeamTypeController;
use App\Http\Controllers\API\User\DashboardController;
use App\Http\Controllers\API\UserDetails\UserController;
use App\Http\Controllers\Order\DeliveryFeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::middleware('login_attempt')->post('/login', [AuthController::class, 'login']);
Route::middleware('login_attempt')->post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/home', [FrontendController::class, 'index'])->name('dashboard.info');

Route::post('/order/confirm', [OrderController::class, 'orderConfirm'])->name('order.confirm');

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/users', UserController::class);
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::get('/user/{id}/show', [AuthController::class, 'userProfile']);
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/role/{role}/permission', [AuthorizationController::class, 'givePermission'])->name('role.assign.permission');
    Route::post('/user/{user}/role', [AuthorizationController::class, 'assignRole'])->name('user.role.assign');
    Route::put('/user/branch/{user}/assign', [UserController::class, 'assignBranch'])->name('user.branch.assign');

    Route::apiResource('role', RoleController::class);
    Route::apiResource('permission', PermissionController::class);

    Route::prefix('team_type')->group(function () {
        Route::put('/{id}/activation', [TeamTypeController::class, 'activation'])->name('team_type.activation');
    });
    Route::apiResource('team_type', TeamTypeController::class);

    Route::prefix('team_member')->group(function () {
        Route::get('/create', [TeamMemberController::class, 'create'])->name('team_member.create');
        Route::put('/{id}/activation', [TeamMemberController::class, 'activation'])->name('team_member.activation');
    });
    Route::apiResource('team_member', TeamMemberController::class);

    Route::prefix('achievement')->group(function () {
        Route::put('/{id}/activation', [AchievementController::class, 'activation'])->name('achievement.activation');
    });
    Route::apiResource('achievement', AchievementController::class);


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard.info');

    Route::prefix('product_category')->group(function () {
        Route::put('/{id}/activation', [ProductCategoryController::class, 'activation'])->name('product_category.activation');
    });
    Route::apiResource('product_category', ProductCategoryController::class);

    Route::prefix('product')->group(function () {
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::put('/{id}/activation', [ProductController::class, 'activation'])->name('product.activation');
    });
    Route::apiResource('product', ProductController::class);

    Route::prefix('supplier')->group(function () {
        Route::put('/{id}/activation', [SupplierController::class, 'activation'])->name('supplier.activation');
    });
    Route::apiResource('supplier', SupplierController::class);

    Route::prefix('branch')->group(function () {
        Route::put('/{id}/activation', [BranchController::class, 'activation'])->name('branch.activation');
        Route::put('/{id}/campaign_details', [BranchController::class, 'campaignAssign'])->name('branch.campaign.assign');
        Route::prefix('store')->group(function () {
            Route::get('/create', [StoreController::class, 'create'])->name('branch.store.create');
            Route::put('/{id}/activation', [StoreController::class, 'activation'])->name('branch.store.activation');
        });
        Route::apiResource('store', StoreController::class);
    });

    Route::get('/branches', [BranchController::class, 'getBranches'])->name('branch.list');
    Route::apiResource('branch', BranchController::class);

    Route::prefix('campaign')->group(function () {
        Route::put('/{id}/activation', [CampaignInfoController::class, 'activation'])->name('campaign.activation');
        Route::prefix('/details')->group(function () {
            Route::get('/create', [CampaignDetailsController::class, 'create'])->name('campaign.details.create');
            Route::put('/{id}/activation', [CampaignDetailsController::class, 'activation'])->name('campaign.details.activation');
        });
        Route::apiResource('/details', CampaignDetailsController::class);
    });
    Route::apiResource('campaign', CampaignInfoController::class);

    Route::get('/customers', [OrderController::class, 'getCustomersList'])->name('order.customers');
    Route::get('/customers_info', [OrderController::class, 'getCustomersInfo'])->name('order.customers.info');


    Route::prefix('order')->group(function () {
        Route::get('/create', [OrderController::class, 'create'])->name('order.create');
        Route::get('/products', [OrderController::class, 'getProductsBySearch'])->name('order.products');
        Route::get('{id}/details', [OrderController::class, 'details'])->name('order.details');
        Route::get('{id}/info', [OrderController::class, 'orderDetails'])->name('order.order_details');
        Route::put('{id}/status', [OrderController::class, 'orderStatus'])->name('order.status.change');
        Route::put('{id}/remark', [OrderController::class, 'orderRemark'])->name('order.remark.update');
        Route::put('{id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
        Route::get('/product', [OrderController::class, 'soldProduct'])->name('product.sale.info');
        Route::get('/product/details/{id}', [OrderController::class, 'soldProductDetails'])->name('product.sale.details');
        Route::post('/product_qty', [OrderController::class, 'productQtyChange'])->name('order.product.qty');
        Route::post('/remove', [OrderController::class, 'itemRemove'])->name('order.item.remove');
        Route::post('/campaign/remove', [OrderController::class, 'campaignRemove'])->name('order.campaign.remove');
        Route::post('/campaign', [OrderController::class, 'campaignStore'])->name('order.campaign');
        Route::post('/payment_type', [OrderController::class, 'paymentTypeStore'])->name('order.payment_type');
        Route::post('/pay_amount', [OrderController::class, 'setPayAmount'])->name('order.pay_amount');
        Route::post('/delivery_fee', [OrderController::class, 'setDeliveryFee'])->name('order.delivery_fee');
        Route::post('/place', [OrderController::class, 'orderPlace'])->name('order.place');
        Route::get('/due/invoice/{id}', [OrderController::class, 'dueInvoice'])->name('order.due.invoice');
        Route::put('/due/pay/{id}', [OrderController::class, 'duePay'])->name('order.due.pay');
        Route::post('/adjustment', [OrderController::class, 'adjustment'])->name('order.adjustment');
        Route::post('/adjustment_date', [OrderController::class, 'adjustmentDate'])->name('order.adjustment_date');
        Route::get('/discounts', [OrderController::class, 'getDiscountList'])->name('order.discount.list');
    });

    Route::prefix('report')->group(function () {
        Route::get('/due', [OrderController::class, 'dueReport'])->name('order.due.report');
        Route::get('/sale/invoice/{order}', [OrderController::class, 'saleInvoiceReport'])->name('order.invoice.report');
        Route::get('/due/print/{order}', [OrderController::class, 'dueReportPrint'])->name('due.report.print');
        Route::get('/discount/print/{order}', [OrderController::class, 'discountReportPrint'])->name('discount.report.print');
        Route::get('/sold/product/invoice', [ReportController::class, 'soldProductInvoice'])->name('sold.product.invoice');
    });

    Route::prefix('payment_info')->group(function () {
        Route::get('/types', [PaymentTypeController::class, 'paymentTypes'])->name('payment_info.types');
        Route::put('/{id}/activation', [PaymentViaController::class, 'activation'])->name('payment_info.activation');
        Route::put('type/{id}/activation', [PaymentTypeController::class, 'activation'])->name('payment_info.type.activation');
        Route::apiResource('type', PaymentTypeController::class);
    });

    Route::apiResource('payment_info', PaymentViaController::class);

    Route::apiResource('supplier', SupplierController::class);

    Route::get('/pos/receipt/{order}', [OrderController::class, 'printSlip'])->name('order.print');

    Route::apiResource('order', OrderController::class);

    Route::prefix('delivery_fee')->group(function () {
        Route::put('/{id}/activation', [DeliveryFeeController::class, 'activation'])->name('delivery_fee.activation');
    });
    Route::apiResource('delivery_fee', DeliveryFeeController::class);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');