<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\SEEController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/sse', [SEEController::class, 'sendSSEData']);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

//Role-----> Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change-password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/change-password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    Route::get('/admin/inactive-vendor', [AdminController::class, 'InActiveVendor'])->name('admin.inactive.vendor');

    Route::get('/admin/active-vendor', [AdminController::class, 'ActiveVendor'])->name('admin.active.vendor');

    Route::get('/admin/inactive-vendor-detail/{id}', [AdminController::class, 'InActiveVendorDetail'])->name('admin.inactive.vendor.detail');

    Route::get('/admin/active-vendor-detail/{id}', [AdminController::class, 'ActiveVendorDetail'])->name('admin.active.vendor.detail');

    Route::post('/admin/inactive-vendor-approve', [AdminController::class, 'InActiveVendorApprove'])->name('admin.inactive.vendor.approve');

    Route::post('/admin/active-vendor-approve', [AdminController::class, 'ActiveVendorApprove'])->name('admin.active.vendor.approve');

    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
});

//Role-----> User
Route::middleware('auth', 'role:user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'Dashboard'])->name('dashboard');
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('/user/profile', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    // Route::post('/user/change-password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::get('/logout', [UserController::class, 'UserDestroy'])->name('user.logout');
});

//Role-----> Vendor
Route::middleware('auth', 'role:vendor')->group(function () {
    // Route::get('/dashboard', [UserController::class, 'Dashboard'])->name('dashboard');
    Route::get('vendor/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    // Route::get('/login', [VendorController::class, 'UserLogin'])->name('login');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
});

//Login
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

//-----------------------------Back-End--------------------------------//

//Sliders
Route::get('/all/slider', [SliderController::class, 'AllSlider'])->name('all.slider');
Route::get('/add/slider', [SliderController::class, 'AddSlider'])->name('add.slider');
Route::post('/store/slider', [SliderController::class, 'StoreSlider'])->name('store.slider');
Route::get('/edit/slider/{id}', [SliderController::class, 'EditSlider'])->name('edit.slider');
Route::post('/update/slider', [SliderController::class, 'UpdateSlider'])->name('update.slider');
Route::get('/delete/slider/{id}', [SliderController::class, 'DeleteSlider'])->name('delete.slider');

//Category
Route::get('/all/category', [CategoryController::class, 'AllCategory'])->name('all.category');
Route::get('/add/category', [CategoryController::class, 'AddCategory'])->name('add.category');
Route::post('/store/category', [CategoryController::class, 'StoreCategory'])->name('store.category');
Route::get('/edit/category/{id}', [CategoryController::class, 'EditCategory'])->name('edit.category');
Route::post('/update/category', [CategoryController::class, 'UpdateCategory'])->name('update.category');
Route::get('/delete/category/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete.category');

//Sub-Category
Route::get('/all/sub-category', [SubCategoryController::class, 'AllSubCategory'])->name('all.sub_category');
Route::get('/add/sub-category', [SubCategoryController::class, 'AddSubCategory'])->name('add.sub_category');
Route::post('/store/sub-category', [SubCategoryController::class, 'StoreSubCategory'])->name('store.sub_category');
Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);

//Brand
Route::get('/all/brand', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::get('/add/brand', [BrandController::class, 'AddBrand'])->name('add.brand');
Route::post('/store/brand', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/edit/brand/{id}', [BrandController::class, 'EditBrand'])->name('edit.brand');
Route::post('/update/brand', [BrandController::class, 'UpdateBrand'])->name('update.brand');
Route::get('/delete/brand/{id}', [BrandController::class, 'DeleteBrand'])->name('delete.brand');

//Banner
Route::get('/all/banner', [BannerController::class, 'AllBanner'])->name('all.banner');
Route::get('/add/banner', [BannerController::class, 'AddBanner'])->name('add.banner');
Route::post('/store/banner', [BannerController::class, 'StoreBanner'])->name('store.banner');
Route::get('/edit/brand/{id}', [BannerController::class, 'EditBanner'])->name('edit.banner');
Route::post('/update/banner', [BannerController::class, 'UpdateBanner'])->name('update.banner');
Route::get('/delete/banner/{id}', [BannerController::class, 'DeleteBanner'])->name('delete.banner');

//Product
Route::get('/all/product', [ProductController::class, 'AllProduct'])->name('all.product');
Route::get('/add/product', [ProductController::class, 'AddProduct'])->name('add.product');
Route::post('/store/product', [ProductController::class, 'StoreProduct'])->name('store.product');
// For Product Stock
Route::get('/product/stock', [ProductController::class, 'ProductStock'])->name('product.stock');

//-------------------Front-End-------------------------//

//Product Detail
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetail']);
//All Vendor
Route::get('/all/vendor', [IndexController::class, 'AllVendor'])->name('all.vendor');
// Product View Modal With Ajax
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);

// Search All Route 
Route::controller(IndexController::class)->group(function () {
    Route::post('/search', 'ProductSearch')->name('product.search');
    Route::post('/search-product', 'SearchProduct');
});

//Cart
// Add to cart store data
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
// Get Data from mini Cart
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
//Remove Cart
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
/// Add to cart store data For Product Details Page 
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);

// Cart All Route 
Route::controller(CartController::class)->group(function () {
    Route::get('/user/mycart', 'MyCart')->name('mycart');
    Route::get('/get-cart-product', 'GetCartProduct');
    Route::get('/cart-remove/{rowId}', 'CartRemove');

    Route::get('/cart-decrement/{rowId}', 'CartDecrement');
    Route::get('/cart-increment/{rowId}', 'CartIncrement');
});

/// Frontend Coupon Option
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

// Checkout Page Route 
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

// Coupon
Route::controller(CouponController::class)->group(function () {
    Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
    Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
    Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');
    Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
    Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
    Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
});

// Shipping Division All Route 
Route::controller(ShippingAreaController::class)->group(function () {
    Route::get('/all/division', 'AllDivision')->name('all.division');
    Route::get('/add/division', 'AddDivision')->name('add.division');
    Route::post('/store/division', 'StoreDivision')->name('store.division');
    Route::get('/edit/division/{id}', 'EditDivision')->name('edit.division');
    Route::post('/update/division', 'UpdateDivision')->name('update.division');
    Route::get('/delete/division/{id}', 'DeleteDivision')->name('delete.division');
});

// Shipping District All Route 
Route::controller(ShippingAreaController::class)->group(function () {
    Route::get('/all/district', 'AllDistrict')->name('all.district');
    Route::get('/add/district', 'AddDistrict')->name('add.district');
    Route::post('/store/district', 'StoreDistrict')->name('store.district');
    Route::get('/edit/district/{id}', 'EditDistrict')->name('edit.district');
    Route::post('/update/district', 'UpdateDistrict')->name('update.district');
    Route::get('/delete/district/{id}', 'DeleteDistrict')->name('delete.district');
});

// Shipping State All Route 
Route::controller(ShippingAreaController::class)->group(function () {
    Route::get('/all/state', 'AllState')->name('all.state');
    Route::get('/add/state', 'AddState')->name('add.state');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');

    Route::get('/district/ajax/{division_id}', 'GetDistrict');
});

// Checkout All Route 
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/district-get/ajax/{division_id}', 'DistrictGetAjax');
    Route::get('/state-get/ajax/{district_id}', 'StateGetAjax');
    Route::post('/checkout/store', 'CheckoutStore')->name('checkout.store');
});

// Stripe All Route 
Route::controller(StripeController::class)->group(function () {
    Route::post('/stripe/order', 'StripeOrder')->name('stripe.order');
    Route::post('/cash/order', 'CashOrder')->name('cash.order');
});

// Admin Order All Route 
Route::controller(OrderController::class)->group(function () {
    Route::get('/pending/order', 'PendingOrder')->name('pending.order');
    Route::get('/admin/order/details/{order_id}', 'AdminOrderDetails')->name('admin.order.details');
    Route::get('/admin/confirmed/order', 'AdminConfirmedOrder')->name('admin.confirmed.order');
    Route::get('/admin/processing/order', 'AdminProcessingOrder')->name('admin.processing.order');
    Route::get('/admin/delivered/order', 'AdminDeliveredOrder')->name('admin.delivered.order');
    Route::get('/pending/confirm/{order_id}', 'PendingToConfirm')->name('pending-confirm');
    Route::get('/confirm/processing/{order_id}', 'ConfirmToProcess')->name('confirm-processing');
    Route::get('/processing/delivered/{order_id}', 'ProcessToDelivered')->name('processing-delivered');
    Route::get('/admin/invoice/download/{order_id}', 'AdminInvoiceDownload')->name('admin.invoice.download');
});

// Vendor Order Route 
Route::controller(VendorOrderController::class)->group(function () {
    Route::get('/vendor/order', 'VendorOrder')->name('vendor.order');
});

// User Dashboard All Route 
Route::controller(AllUserController::class)->group(function () {
    Route::get('/user/account/page', 'UserAccount')->name('user.account.page');
    Route::get('/user/change/password', 'UserChangePassword')->name('user.change.password');
    Route::post('/user/update/password', 'UserUpdatePassword')->name('user.update.password');
    Route::get('/user/order/page', 'UserOrderPage')->name('user.order.page');
    Route::get('/user/order_details/{order_id}', 'UserOrderDetails');
    Route::get('/user/invoice_download/{order_id}', 'UserOrderInvoice');
    Route::post('/return/order/{order_id}', 'ReturnOrder')->name('return.order');
    Route::get('/return/order/page', 'ReturnOrderPage')->name('return.order.page');
    // Order Tracking 
    Route::get('/user/track/order', 'UserTrackOrder')->name('user.track.order');
    Route::post('/order/tracking', 'OrderTracking')->name('order.tracking');
});

// Return Order All Route 
Route::controller(ReturnController::class)->group(function () {
    Route::get('/return/request', 'ReturnRequest')->name('return.request');
    Route::get('/complete/return/request', 'CompleteReturnRequest')->name('complete.return.request');
});

// Report All Route 
Route::controller(ReportController::class)->group(function () {

    Route::get('/report/view', 'ReportView')->name('report.view');
    Route::post('/search/by/date', 'SearchByDate')->name('search-by-date');
    Route::post('/search/by/month', 'SearchByMonth')->name('search-by-month');
    Route::post('/search/by/year', 'SearchByYear')->name('search-by-year');
    Route::get('/order/by/user', 'OrderByUser')->name('order.by.user');
    Route::post('/search/by/user', 'SearchByUser')->name('search-by-user');
});

// Frontend Blog Post All Route 
Route::controller(ReviewController::class)->group(function () {
    Route::post('/store/review', 'StoreReview')->name('store.review');
    Route::get('/pending/review', 'PendingReview')->name('pending.review');
    Route::get('/review/approve/{id}', 'ReviewApprove')->name('review.approve');
    Route::get('/publish/review', 'PublishReview')->name('publish.review');
    Route::get('/review/delete/{id}', 'ReviewDelete')->name('review.delete');
});

// Site Setting All Route 
Route::controller(SiteSettingController::class)->group(function () {

    Route::get('/site/setting', 'SiteSetting')->name('site.setting');
    Route::post('/site/setting/update', 'SiteSettingUpdate')->name('site.setting.update');
    Route::get('/seo/setting', 'SeoSetting')->name('seo.setting');
    Route::post('/seo/setting/update', 'SeoSettingUpdate')->name('seo.setting.update');
});

// // Permission All Route
Route::controller(RoleController::class)->group(function () {
    Route::get('/all/permission', 'AllPermission')->name('all.permission');
    Route::get('/add/permission', 'AddPermission')->name('add.permission');
    Route::post('/store/permission', 'StorePermission')->name('store.permission');
    Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
    Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
    Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
});

// Roles All Route 
Route::controller(RoleController::class)->group(function () {

    Route::get('/all/roles', 'AllRoles')->name('all.roles');
    Route::get('/add/roles', 'AddRoles')->name('add.roles');
    Route::post('/store/roles', 'StoreRoles')->name('store.roles');
    Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
    Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
    Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');
    // add role permission 
    Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
    Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
    Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
    Route::get('/admin/edit/roles/{id}', 'AdminRolesEdit')->name('admin.edit.roles');
    Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
    Route::get('/admin/delete/roles/{id}', 'AdminRolesDelete')->name('admin.delete.roles');
});

// Active user and vendor All Route 
Route::controller(ActiveUserController::class)->group(function () {
    Route::get('/all/user', 'AllUser')->name('all-user');
    Route::get('/all/vendor', 'AllVendor')->name('all-vendor');
});
