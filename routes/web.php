<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\UserOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/shop', function () {
//     return view('shop.index');
// })->name('shop.index');

// Route::get('/index', function () {
//     return view('/shop/index');
// });

Route::get('/about', function () {
    return view('/shop/about');
});

Route::get('/contacts', function () {
    return view('/shop/contacts');
});

Route::get('/checkout', function () {
    return view('/shop/checkout');
});

Route::get('/login', function () {
    return view('/shop/login');
});

Route::get('/dangky', function () {
    return view('/shop/dangky');
});

Route::get('/pricing', function () {
    return view('/shop/pricing');
});

Route::get('/shopping_cart', function () {
    return view('/shop/shopping_cart');
});

Route::get('/product', function () {
    return view('/shop/product');
});

Route::get('/product_type', function () {
    return view('/shop/product_type');
});

Route::get('/404', function () {
    return view('/shop/404');
});


// adm




Route::prefix('admin')->group(function () {
    Route::get('/login', [ADMController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [ADMController::class, 'postLogin'])->name('admin.login.post');

    Route::middleware('auth')->group(function () {
        Route::get('/cate_list', [ADMController::class, 'showCate'])->name('admin.cate');
        Route::get('/cate_add', [ADMController::class, 'addCate'])->name('admin.cate.add');
        Route::get('/cate_edit', [ADMController::class, 'editCate'])->name('admin.cate.edit');
        Route::get('/product_list', [ADMController::class, 'showProduct'])->name('admin.product');
        Route::get('/product_add', [ADMController::class, 'addProduct'])->name('admin.product.add');
        Route::get('/product_edit/{id}', [ADMController::class, 'editProduct'])->name('admin.product.edit');
        Route::get('/product_delete/{id}', [ADMController::class, 'deleteProduct'])->name('admin.product.delete'); // Add this route
        Route::get('/user_list', [ADMController::class, 'showUser'])->name('admin.user');
        Route::get('/user_add', [ADMController::class, 'addUser'])->name('admin.user.add');
        Route::get('/user_edit', [ADMController::class, 'editUser'])->name('admin.user.edit');
    });
});
Route::get('/increase-by-one/{id}', [PageController::class, 'increaseByOne'])->name('banhang.increaseByOne');
Route::get('/reduce-by-one/{id}', [PageController::class, 'reduceByOne'])->name('banhang.reduceByOne');
Route::get('/remove-item/{id}', [PageController::class, 'removeItem'])->name('banhang.removeItem');

Route::get('/index', [PageController::class, 'getIndex'])->name('banhang.index');
Route::get('shop.product{sanpham_id}', [PageController::class, 'getChiTiet'])->name('banhang.chitiet');
Route::get('/add-to-cart/{id}', [PageController::class, 'addToCart'])->name('banhang.addtocart');

Route::get('/shopping_cart', function () {
    return view('shop.shopping_cart');
})->name('banhang.shopping_cart');

Route::get('checkout', [PageController::class, 'getCheckout'])->name('banhang.getdathang');
Route::get('/xoagiohang/{id}', [PageController::class, 'deleteCartItem'])->name('banhang.xoagiohang');


Route::post('checkout', [PageController::class, 'postCheckout'])->name('banhang.postdathang');

Route::get('/dangky', [PageController::class, 'getSignin'])->name('getsignin');
Route::post('/dangky', [PageController::class, 'postSignin'])->name('postsignin');

Route::get('/login', [PageController::class, 'getLogin'])->name('getlogin');
Route::post('/login', [PageController::class, 'postLogin'])->name('postlogin');

// Đảm bảo route shop.index đã được định nghĩa
Route::get('/shop', [PageController::class, 'getIndex'])->name('shop.index');

Route::get('/dangxuat', [PageController::class, 'getLogout'])->name('getlogout');

Route::get('/order-success', [PageController::class, 'orderSuccess'])->name('banhang.order-success');

Route::post('/input-email', [PageController::class, 'postInputEmail'])->name('postInputEmail');
Route::get('/input-email', [PageController::class, 'getInputEmail'])->name('getInputEmail');

Route::get('/product_type/{id}', [PageController::class, 'showProductType'])->name('showproducttype');
Route::get('/product_type/{id}', [PageController::class, 'showByType']);

Route::get('/favorite/{productId}', [PageController::class, 'toggleFavorite'])->name('product.toggleFavorite');
Route::get('/favorites', [PageController::class, 'showFavorites'])->name('favorites');  // Định nghĩa route cho favorites

// Route cho trang quản lý chat


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Route hiển thị danh sách tin nhắn
    Route::get('/chat', [ADMController::class, 'index'])->name('chat.index');

    // Route hiển thị chi tiết tin nhắn và form trả lời
    Route::get('/chat/{id}', [ADMController::class, 'show'])->name('chat.show');

    // Route xử lý trả lời tin nhắn
    Route::post('/chat/{id}', [ADMController::class, 'reply'])->name('chat.reply');
});

Route::get('/order-success', [PageController::class, 'orderSuccess'])->name('banhang.order-success');

Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');

Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{order}/details', [OrderController::class, 'details'])->name('orders.details');

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
});


Route::get('/check-session', function () {
    return Session::all();
});
