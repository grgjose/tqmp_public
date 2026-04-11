<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\BulletProofingController;
use App\Http\Controllers\GlassManufacturingController;
use App\Http\Controllers\AluminumManufacturingController;
use App\Http\Controllers\GlassProcessingController;
use App\Http\Controllers\GenTradeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ConsumerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderSummaryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\UserAuth;
use App\Http\Middleware\SalesAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\AllUserAuth;
use App\Http\Middleware\CheckNotification;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/register', [UserController::class, 'register']);
Route::post('/register', [UserController::class, 'signup']);
Route::get('/confirmation/{token}', [UserController::class, 'confirmation']);
Route::get('/product-details', [ProductDetailsController::class, 'index']);
Route::get('/home', [HomeController::class, 'home']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/inquiry-store', [HomeController::class, 'addInquiry']);
Route::post('/login', [UserController::class, 'logon']);
Route::post('/login_otp_get', [UserController::class, 'logon_otp_get']);
Route::post('/login_otp_post', [UserController::class, 'logon_otp_post']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/forgot-password', [UserController::class, 'forgot']);
Route::get('/reset/{reference}', [UserController::class, 'reset']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/bulletproofing', [BulletProofingController::class, 'index']);
Route::get('/glassmanufacturing', [GlassManufacturingController::class, 'index']);
Route::get('/aluminummanufacturing', [AluminumManufacturingController::class, 'index']);
Route::get('/glassprocessing', [GlassProcessingController::class, 'index']);
Route::get('/gentrade', [GenTradeController::class, 'index']);
Route::get('/catalog', [CatalogController::class, 'show']);
Route::get('/shop', [HomeController::class, 'shop']);
Route::get('/faqs', [HomeController::class, 'FAQs']);
Route::get('/emailTest', [ProductController::class, 'emailTest']);

// SMS
Route::get('/number', [HomeController::class, 'number']);
Route::get('/otp', [HomeController::class, 'otp']);
Route::get('/success', [HomeController::class, 'success']);
Route::get('/unsuccessful', [HomeController::class, 'unsuccessful']);




/*
|--------------------------------------------------------------------------
| All User Protected Routes (AllUserAuth) — All Roles (usertype=3 || 2 || 1)
|--------------------------------------------------------------------------
*/
Route::middleware([AllUserAuth::class])->group(function () {

    // API Calls
    Route::post('/lalamoveGetQuotation', [OrderController::class, 'lalamoveGetQuotation'])->name('lalamove.getQuotation');
    Route::get('/lalamoveGetQuotation', [OrderController::class, 'lalamoveGetQuotation']);
    Route::get('/lalamoveGetQuotationDetails', [OrderController::class, 'lalamoveGetQuotationDetails']);
    Route::get('/lalamovePlaceOrder', [OrderController::class, 'lalamovePlaceOrder']);
    Route::get('/lalamoveGetOrderDetails', [OrderController::class, 'lalamoveGetOrderDetails']);
    Route::get('/lalamoveCancelOrder', [OrderController::class, 'lalamoveCancelOrder']);

    Route::get('/user-counts', function () {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'cart' => 0,
                'orders' => 0,
                'quotations' => 0
            ]);
        }

        return response()->json([
            'cart' => \App\Models\Cart::where('user_id', $user->id)->count(),
            'orders' => \App\Models\Order::where('customer_id', $user->id)
                            ->where('status', '!=', 'Cancelled')
                            ->where('status', '!=', 'Completed')
                            ->count(),
            'quotations' => \App\Models\Quotation::where('user_id', $user->id)
                            ->where('status', '!=', 'Cancelled')
                            ->count(),
        ]);
    });

});




/*
|--------------------------------------------------------------------------
| User Protected Routes (UserAuth) — Customers Only (usertype=3)
|--------------------------------------------------------------------------
*/
Route::middleware([UserAuth::class])->group(function () {
    // Profile & Account
    Route::get('/profile', [HomeController::class, 'profile']);
    Route::post('/confirm-password', [UserController::class, 'confirmPassword'])->name('confirm.password');
    Route::post('/confirm-username', [UserController::class, 'confirmUsername'])->name('confirm.username');
    Route::get('/adminprofile', [UserProfileController::class, 'adminprofile']);
    Route::get('/profile-set-shipping', [HomeController::class, 'setShippingProfile']);
    Route::post('/save-profile', [HomeController::class, 'saveProfile']);
    Route::post('/profile-save-shipping', [HomeController::class, 'saveShipping']);

    // Notifications
    Route::get('/notification_user', [NotificationController::class, 'notification_user']);
    Route::get('/notifications', [NotificationController::class, 'notification']);

    // Quotation File Handling
    Route::get('/download-conforme-user/{id}/{from?}', [QuotationController::class, 'downloadConformeUser']);
    Route::get('/download-ar-user/{id}/{from?}', [QuotationController::class, 'downloadARUser']);
    Route::post('/upload-conforme-user/{id}', [QuotationController::class, 'uploadConformeUser']);
    Route::post('/upload-ar-user/{id}', [QuotationController::class, 'uploadARUser']);
    Route::post('/upload-proof-of-payment/{id}', [QuotationController::class, 'uploadProofOfPayment']);
    Route::get('/download-conforme-sp/{id}', [QuotationController::class, 'downloadConformeSalesRep']);
    Route::get('/download-ar-sp/{id}', [QuotationController::class, 'downloadARSalesRep']);
    Route::post('/upload-conforme-sp/{id}', [QuotationController::class, 'uploadConformeSalesRep']);
    Route::post('/upload-ar-sp/{id}', [QuotationController::class, 'uploadARSalesRep']);
    Route::get('/download-proof-of-payment/{id}', [QuotationController::class, 'downloadProofOfPayment']);

    // Quotations (with CheckNotification)
    Route::get('/show-quotation-messages/{reference}', [QuotationController::class, 'showQuotationMessages'])->middleware(CheckNotification::class);
    Route::get('/show-quotation/{reference}', [QuotationController::class, 'showQuotation'])->middleware(CheckNotification::class);
    Route::get('/quotes-status', [HomeController::class, 'QuoteStatus'])->middleware(CheckNotification::class);
    Route::get('/quotation-download', [QuotationController::class, 'downloadConforme']);
    Route::get('/get-quotation-bulletproofing', [QuotationController::class, 'quotationBulletProofing']);
    Route::get('/get-quotation-glassprocessing', [QuotationController::class, 'quotationGlassProcessing']);
    Route::post('/create-quotation', [QuotationController::class, 'store']);
    Route::post('/user-send-message', [QuotationController::class, 'userSendMessage']);
    Route::post('/cancel-quotation', [QuotationController::class, 'cancel']);
    Route::post('/approve-quotation', [QuotationController::class, 'approve']);
    Route::post('/quotation-to-cart', [QuotationController::class, 'quotationToCart']);

    // Cart & Orders (with CheckNotification)
    Route::get('/add-to-cart/{id}', [ProductController::class, 'before_add_to_cart'])->middleware(CheckNotification::class);
    Route::post('/add-to-cart/{id}', [ProductController::class, 'after_add_to_cart'])->middleware(CheckNotification::class);
    Route::get('/cart', [ProductController::class, 'cart'])->middleware(CheckNotification::class);
    Route::get('/order-status', [HomeController::class, 'OrderStatus'])->middleware(CheckNotification::class);
    Route::get('/order-status/{reference}', [ProductController::class, 'order_status'])->middleware(CheckNotification::class);
    Route::post('/remove-cart-item/{id}', [ProductController::class, 'remove']);
    Route::get('/import', [ProductController::class, 'import']);
    Route::get('/set-shipping', [OrderController::class, 'setShipping']);
    Route::post('/save-shipping', [OrderController::class, 'saveShipping']);
    Route::post('/checkout', [ProductController::class, 'checkout']);
    Route::post('/checkout_otp_get', [ProductController::class, 'checkout_otp_get']);
    Route::post('/checkout_otp_post', [ProductController::class, 'checkout_otp_post']);
    Route::get('/order-summary', [OrderSummaryController::class, 'index']);
    Route::get('/order_status', [ProductController::class, 'order_status']);

    // User Pages
    Route::get('/user_messages', [UserProfileController::class, 'user_messages']);
    Route::get('/messages', [UserProfileController::class, 'messages']);
    Route::get('/process_order', [UserProfileController::class, 'process_order']);
    Route::get('/hidden_store', [UserProfileController::class, 'hidden_store']);
    Route::get('/main_quote', [UserProfileController::class, 'main_quote']);
    Route::get('/quote_msg', [UserProfileController::class, 'quote_msg']);
    Route::get('/quotation_bulletproof', [UserProfileController::class, 'quotation_bulletproof']);
    Route::get('/quotation_glasspro', [UserProfileController::class, 'quotation_glasspro']);
    Route::get('/shipping', [UserProfileController::class, 'shipping']);
    Route::get('/receipt', [UserProfileController::class, 'receipt']);
});

/*
|--------------------------------------------------------------------------
| Sales Protected Routes (SalesAuth) — Admin (usertype=1) & Sales (usertype=2)
|--------------------------------------------------------------------------
*/
Route::middleware([SalesAuth::class])->group(function () {
    // Dashboard & Orders
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/ticketing', [OrderController::class, 'ticketing']);
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::post('/inventory-update/{id}', [InventoryController::class, 'update']);

    Route::get('/order', [OrderController::class, 'index']);
    Route::post('/order-status-change/{id}', [OrderController::class, 'changeStatus']);
    Route::get('/order-get-quotation/{id}', [OrderController::class, 'getQuotation']);
    Route::get('/order-get-quotation/{id}/{type}', [OrderController::class, 'getQuotation']);
    Route::get('/order-get-quotation/{id}/{type}/{quantity}', [OrderController::class, 'getQuotation']);
    Route::post('/order-place-order', [OrderController::class, 'placeOrder']);
    Route::get('/order-get-order-details/{orderId}', [OrderController::class, 'getOrderDetails']);
    Route::get('/order-get-driver-details/{orderId}/{driverId}', [OrderController::class, 'getDriverDetails']);
    Route::post('/order-cancel-order', [OrderController::class, 'cancelOrder']);

    // Quotations
    Route::get('/quotations', [QuotationController::class, 'index']);
    Route::get('/quotations-view/{id}', [QuotationController::class, 'show']);
    Route::get('/quotations-create', [QuotationController::class, 'create']);
    Route::post('/quotations-store', [QuotationController::class, 'store']);
    Route::get('/quotations-edit/{id}', [QuotationController::class, 'edit']);
    Route::put('/quotations-update/{id}', [QuotationController::class, 'update']);
    Route::post('/quotations-destroy/{id}', [QuotationController::class, 'destroy']);
    Route::post('/send-message', [QuotationController::class, 'sendMessage']);
    Route::post('/quotation/update-status', [QuotationController::class, 'updateStatus'])->name('quotation.updateStatus');
    Route::post('/quotation-status-change/{id}', [QuotationController::class, 'changeStatus']);
    Route::post('/quotation/update-status-sales/{id}', [QuotationController::class, 'updateStatusSales']);

    // Consumers & Approvals
    Route::get('/consumers', [UserController::class, 'consumers']);
    Route::get('/apply-discount/{id}', [UserController::class, 'applyDiscount']);
    Route::get('/apply-special-discount/{id}', [UserController::class, 'applySpecialDiscount']);
    Route::get('/remove-discount/{id}', [UserController::class, 'removeDiscount']);
    Route::get('/approvals', [UserController::class, 'approvals']);
    Route::get('/approvals-view/{id}', [UserController::class, 'approvals_show']);
    Route::get('/approvals-download/{id}', [UserController::class, 'approvals_download']);
    Route::post('/approvals-approve', [UserController::class, 'approvals_approve']);
    Route::post('/approvals-reject/{id}', [UserController::class, 'approvals_reject']);

    // Inquiries
    Route::get('/inquiries', [InquiryController::class, 'index']);
    Route::get('/inquiries-view/{id}', [InquiryController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (AdminAuth) — Admin Only (usertype=1)
|--------------------------------------------------------------------------
*/
Route::middleware([AdminAuth::class])->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users-view/{id}', [UserController::class, 'show']);
    Route::get('/users-create', [UserController::class, 'create']);
    Route::post('/users-store', [UserController::class, 'store']);
    Route::get('/users-update/{id}', [UserController::class, 'edit']);
    Route::post('/users-update/{id}', [UserController::class, 'update']);
    Route::post('/users-destroy/{id}', [UserController::class, 'destroy']);
    Route::post('/users-changepic/{id}', [UserController::class, 'changepic']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products-view/{id}', [ProductController::class, 'show']);
    Route::get('/products-create', [ProductController::class, 'create']);
    Route::post('/products-store', [ProductController::class, 'store']);
    Route::get('/products-edit/{id}', [ProductController::class, 'edit']);
    Route::put('/products-update/{id}', [ProductController::class, 'update']);
    Route::post('/products-destroy/{id}', [ProductController::class, 'destroy']);

    // Product Categories
    Route::get('/product-categories', [ProductCategoryController::class, 'index']);
    Route::get('/product-categories-view/{id}', [ProductCategoryController::class, 'show']);
    Route::get('/product-categories-create', [ProductCategoryController::class, 'create']);
    Route::post('/product-categories-store', [ProductCategoryController::class, 'store']);
    Route::get('/product-categories-edit/{id}', [ProductCategoryController::class, 'edit']);
    Route::put('/product-categories-update/{id}', [ProductCategoryController::class, 'update']);
    Route::post('/product-categories-destroy/{id}', [ProductCategoryController::class, 'destroy']);

    // Product Sub Categories
    Route::post('/product-sub-categories-store', [ProductCategoryController::class, 'subCategoryStore']);
    Route::post('/product-sub-categories-update/{id}', [ProductCategoryController::class, 'subCategoryUpdate']);
    Route::post('/product-sub-categories-destroy/{id}', [ProductCategoryController::class, 'subCategoryDestroy']);

    // Product Variants
    Route::get('/product-variants', [ProductVariantController::class, 'index']);
    Route::get('/product-variants-view/{id}', [ProductVariantController::class, 'show']);
    Route::get('/product-variants-create', [ProductVariantController::class, 'create']);
    Route::post('/product-variants-store', [ProductVariantController::class, 'store']);
    Route::get('/product-variants-edit/{id}', [ProductVariantController::class, 'edit']);
    Route::put('/product-variants-update/{id}', [ProductVariantController::class, 'update']);
    Route::post('/product-variants-destroy/{id}', [ProductVariantController::class, 'destroy']);

    // Catalogue
    Route::get('/catalogue', [CatalogueController::class, 'index']);
    Route::get('/catalogue-view/{id}', [CatalogueController::class, 'show']);
    Route::get('/catalogue-create', [CatalogueController::class, 'create']);
    Route::post('/catalogue-store', [CatalogueController::class, 'store']);
    Route::get('/catalogue-edit/{id}', [CatalogueController::class, 'edit']);
    Route::put('/catalogue-update/{id}', [CatalogueController::class, 'update']);
    Route::post('/catalogue-destroy/{id}', [CatalogueController::class, 'destroy']);

    // Admin Control & Audit
    Route::get('/notification_admin', [NotificationController::class, 'notification_admin']);
    Route::get('/get_notification_admin', [NotificationController::class, 'get_notification_admin']);
    Route::get('/audit-trail', [AdminController::class, 'audit']);
    Route::get('/admin-control', [AdminController::class, 'index']);
    Route::get('/admin-control/tab/{name}', [AdminController::class, 'loadTab'])->name('admin-controller.loadTab');
    Route::post('/admin-control/update/{id}', [AdminController::class, 'update']);
    Route::post('/admin-control/store', [AdminController::class, 'store']);
});