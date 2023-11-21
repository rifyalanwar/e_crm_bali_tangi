<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

use App\Http\Controllers\Front\RajaongkirController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');
    Route::group(['middleware' => ['admin']], function () {
        // Admin Dashboard Route
        Route::get('dashboard', 'AdminController@dashboard');

        // Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password', 'AdminController@updateAdminPassword');

        // Check Admin Password
        Route::post('check-admin-password', 'AdminController@checkAdminPassword');

        // Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // View Admins / Subadmins /
        Route::get('admins/{type?}', 'AdminController@admins');

        // Add Admin
        Route::match(['get', 'post'], 'add-admins', 'AdminController@addAdmin');

        // Update Admin Status
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');

        // Admin Logout
        Route::get('logout', 'AdminController@logout');

        // Categories
        Route::get('categories', 'CategoryController@categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');

        // Products
        Route::get('products', 'ProductsController@products');
        Route::post('update-product-status', 'ProductsController@updateProductStatus');
        Route::get('delete-product/{id}', 'ProductsController@deleteProduct');
        Route::match(['get', 'post'], 'add-edit-product/{id?}', 'ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}', 'ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}', 'ProductsController@deleteProductVideo');

        // Attributes
        Route::match(['get', 'post'], 'add-edit-attributes/{id}', 'ProductsController@addAttributes');
        Route::post('update-attribute-status', 'ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}', 'ProductsController@deleteAttribute');
        Route::match(['get', 'post'], 'edit-attributes/{id}', 'ProductsController@editAttributes');


        // Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductsController@addImages');
        Route::post('update-image-status', 'ProductsController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductsController@deleteImage');

        //Banners
        Route::get('banners', 'BannersController@banners');
        Route::post('update-banner-status', 'BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}', 'BannersController@deleteBanner');
        Route::match(['get', 'post'], 'add-edit-banner/{id?}', 'BannersController@addEditBanner');

        //Users
        Route::get('users', 'UsersController@users');

        //Reports
        Route::get('customer-reports', 'ReportsController@customerReports');
        Route::get('transaction-reports', 'ReportsController@transactionReports');

        //Reviews
        Route::get('reviews', 'ReviewsController@reviews');
        Route::post('update-review-status', 'ReviewsController@updateReviewStatus');

        //Newsletters
        Route::get('newsletters', 'NewslettersController@newsletters');

        //Orders
        Route::get('orders', 'OrdersController@orders');
        Route::get('orders/{id}', 'OrdersController@orderDetails');
        Route::post('update-order-status', 'OrdersController@updateOrderStatus');

        //Order Invoices
        Route::get('orders/invoice/{id}', 'OrdersController@viewOrderInvoice');

        // Coupons
        Route::get('coupons', 'CouponsController@coupons');
        Route::post('update-coupon-status', 'CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id}', 'CouponsController@deleteCoupon');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', 'CouponsController@addEditCoupon');
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/', 'IndexController@index');

    // Products Catalogue
    Route::get('/produk', 'ProductsController@listing');

    //Product Detail Page
    Route::get('/produk/{id}', 'ProductsController@detail');

    //Get Product attribute price
    Route::post('get-product-price', 'ProductsController@getProductPrice');

    //CMS Page
    Route::get('/about-us', 'PagesController@about');
    Route::get('/contact-us', 'PagesController@contact');

    //Add to Cart Route
    Route::post('cart/add', 'ProductsController@cartAdd');

    // Cart Route
    Route::get('/cart', 'ProductsController@cart');

    // Update cart item quantity
    Route::post('cart/update', 'ProductsController@cartUpdate');

    //Delete cart item
    Route::post('cart/delete', 'ProductsController@cartDelete');

    // Coupons Route
    Route::get('/coupons', 'CouponsController@coupon');

    //User Login or Register
    Route::get('user/login-or-register', 'UserController@loginRegister');

    //User Register
    Route::post('user/register', 'UserController@userRegister');

    Route::group(['middleware' => ['auth']], function () {

        // User Account profile
        Route::match(['GET', 'POST'], 'user/account', 'UserController@userAccount');

        // User Update Password
        Route::post('user/update-password', 'UserController@userUpdatePassword');

        // Apply Coupon
        Route::post('/apply-coupon', 'ProductsController@applyCoupon');

        // Checkout
        Route::match(['GET', 'POST'], '/checkout', 'ProductsController@checkout');

        // Thanks
        Route::get('thanks', 'ProductsController@thanks');

        // Payment
        Route::get('/payment', 'ProductsController@payment');

        // Users Orders
        Route::get('user/orders/{id?}', 'OrderController@orders');
    });

    //User Login
    Route::post('user/login', 'UserController@userLogin');

    // User Logout
    Route::get('user/logout', 'UserController@userLogout');

    //Add Rating and Review
    Route::match(['GET', 'POST'], '/add-review', 'ReviewsController@addReview');

    // Wishlist 
    Route::post('wishlist/add', 'ProductsController@wishlistAdd');
    Route::get('/wishlist', 'ProductsController@wishlist');
    Route::post('wishlist/delete', 'ProductsController@wishlistDelete');

    //Newsletter subscribe Route
    Route::post('/subscribe', 'NewslettersController@subscribe');

    //RajaOngkir
});

Route::prefix('/ongkir')->group(function () {
    Route::get('/provinces', [RajaongkirController::class, 'provinces']);
    Route::get('/cities/{province_id}', [RajaongkirController::class, 'cities']);
    Route::get('/districts/{city_id}', [RajaongkirController::class, 'districts']);
    Route::post('/cost', [RajaongkirController::class, 'cost']);
});
