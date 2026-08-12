<?php

use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminExtraPageController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSendMethodController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [homeController::class,'index'])->name('home');
Route::get('/login', [homeController::class,'login'])->name('login');
Route::post('/login/submit', [homeController::class,'loginSubmit'])->name('login.submit');
Route::get('/search', [homeController::class,'search'])->name('search');
Route::get('/category/{slug}', [homeController::class,'category'])->name('category');
Route::get('/blogs', [homeController::class,'blogs'])->name('blogs');
Route::get('/blog/{slug}', [homeController::class, 'blogShow'])->name('front.blog.show');
Route::get('/product/{slug}', [homeController::class, 'show'])->name('product.detail');
Route::post('/product/{slug}/comment', [homeController::class, 'storeComment'])->name('product.comment.store');
Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');
Route::get('/pay-call-back', [OrderController::class, 'payCallback'])->name('pay.call.back');
Route::get('/pay-result/{code}', [OrderController::class, 'payResult'])->name('pay.result');
Route::get('/order/track', [OrderController::class, 'trackOrder'])->name('order.track');
Route::post('/order/track/result', [OrderController::class, 'trackOrderResult'])->name('order.track.result');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');
Route::get('/cart/sidebar', function () {
    return view('front.partials.cart-sidebar')->render();
})->name('cart.sidebar');
Route::get('/cart/mobile-drawer', function () {
    return view('front.partials.cart-sidebar')->render();
})->name('cart.mobile.drawer');


Route::prefix('/admin')->middleware('auth')->group(function(){
   Route::get('/index', [adminController::class,'index'])->name('admin.index');
   Route::get('/list/index', [adminController::class,'list'])->name('admin.list');
   Route::get('/create', [adminController::class,'create'])->name('admin.create');
   Route::post('/store', [adminController::class,'store'])->name('admin.store');
   Route::get('/edit/{user}', [adminController::class,'edit'])->name('admin.edit');
   Route::put('/update/{user}', [adminController::class,'update'])->name('admin.update');
   Route::delete('/delete/{user}', [adminController::class,'delete'])->name('admin.delete');

   Route::prefix('/category')->group(function(){

          Route::get('/index', [AdminCategoryController::class,'index'])->name('admin.category.index');
          Route::get('/create', [AdminCategoryController::class,'create'])->name('admin.category.create');
          Route::post('/store', [AdminCategoryController::class,'store'])->name('admin.category.store');
          Route::get('/edit/{category}', [AdminCategoryController::class,'edit'])->name('admin.category.edit');
          Route::post('/update/{category}', [AdminCategoryController::class,'update'])->name('admin.category.update');
          Route::delete('/delete/{category}', [AdminCategoryController::class,'delete'])->name('admin.category.delete');
          Route::patch('/change-status/{category}', [AdminCategoryController::class,'changeStatus'])->name('admin.category.change.status');

      Route::prefix('/product')->group(function(){
         Route::get('/index/{category}', [AdminCategoryController::class,'categoryProductIndex'])->name('admin.category.product.index');
      });
   });
   Route::prefix('/product')->group(function(){
         Route::get('/index', [AdminProductController::class,'index'])->name('admin.product.index');
         Route::get('/create', [AdminProductController::class,'create'])->name('admin.product.create');
         Route::post('/store', [AdminProductController::class,'store'])->name('admin.product.store');
         Route::get('/edit/{product}', [AdminProductController::class,'edit'])->name('admin.product.edit');
         Route::put('/update/{product}', [AdminProductController::class,'update'])->name('admin.product.update');
         Route::delete('/delete/{product}', [AdminProductController::class,'delete'])->name('admin.product.delete');
       Route::patch('/change-status/{product}', [AdminProductController::class,'changeStatus'])->name('admin.product.change.status');

         Route::get('/comment/list/{product}', [AdminProductController::class,'commentList'])->name('admin.product.comment.list');
         Route::get('/comment/create/{product}', [AdminProductController::class,'commentCreate'])->name('admin.product.comment.create');
         Route::post('/comment/store/{product}', [AdminProductController::class,'commentStore'])->name('admin.product.comment.store');
       Route::get('/comment/edit/{product}/{comment}', [AdminProductController::class,'commentEdit'])->name('admin.product.comment.edit');
       Route::put('/comment/update/{product}/{comment}', [AdminProductController::class,'commentUpdate'])->name('admin.product.comment.update');
       Route::delete('/comment/delete/{comment}', [AdminProductController::class,'commentDelete'])->name('admin.product.comment.delete');

       Route::get('/payment-gateway',[AdminController::class,'paymentGatewayForm'])->name('admin.payment-gateway');
       Route::put('/payment-gateway/{gateway}',[AdminController::class,'paymentGatewayUpdate'])->name('admin.payment-gateway.update');

   });
   Route::prefix('/blog')->group(function(){
       Route::get('/index', [AdminBlogController::class,'index'])->name('admin.blog.index');
       Route::get('/create', [AdminBlogController::class,'create'])->name('admin.blog.create');
       Route::post('/store', [AdminBlogController::class,'store'])->name('admin.blog.store');
       Route::get('/edit/{blog}', [AdminBlogController::class,'edit'])->name('admin.blog.edit');
       Route::put('/update/{blog}', [AdminBlogController::class,'update'])->name('admin.blog.update');
       Route::delete('/delete/{blog}', [AdminBlogController::class,'delete'])->name('admin.blog.delete');
   });
   Route::prefix('/order')->group(function(){
     Route::get('/index', [AdminOrderController::class,'index'])->name('admin.order.index');
     Route::get('/show/{order}', [AdminOrderController::class,'show'])->name('admin.order.show');
     Route::put('/update/{order}', [AdminOrderController::class,'update'])->name('admin.order.update');
       Route::get('/{id}/invoice-pdf', [AdminOrderController::class, 'downloadInvoicePdf'])->name('admin.order.invoice-pdf');
   });
   Route::prefix('/banner')->group(function(){
       Route::get('/index', [AdminBannerController::class, 'index'])->name('admin.banners.index');
       Route::post('/store', [AdminBannerController::class, 'store'])->name('admin.banners.store');
       Route::delete('/delete/{banner}', [AdminBannerController::class, 'destroy'])->name('admin.banners.destroy');
   });
   Route::prefix('/send-method')->group(function(){
       Route::get('/index',[AdminSendMethodController::class,'index'])->name('admin.send-method.index');
       Route::get('/create',[AdminSendMethodController::class,'create'])->name('admin.send-method.create');
       Route::post('/store',[AdminSendMethodController::class,'store'])->name('admin.send-method.store');
       Route::get('/edit/{send_method}', [AdminSendMethodController::class,'edit'])->name('admin.send-method.edit');
       Route::put('/update/{send_method}', [AdminSendMethodController::class,'update'])->name('admin.send-method.update');
       Route::delete('/delete/{send_method}', [AdminSendMethodController::class,'delete'])->name('admin.send-method.delete');
   });
    Route::post('/upload-image', [AdminBlogController::class, 'uploadImage'])->name('admin.upload.image');
    Route::prefix('/extra-page')->group(function(){
        Route::get('/index', [AdminExtraPageController::class,'index'])->name('admin.extra.page.index');
        Route::get('/create', [AdminExtraPageController::class,'create'])->name('admin.extra.page.create');
        Route::post('/store', [AdminExtraPageController::class,'store'])->name('admin.extra.page.store');
        Route::get('/edit/{page}', [AdminExtraPageController::class,'edit'])->name('admin.extra.page.edit');
        Route::put('/update/{page}', [AdminExtraPageController::class,'update'])->name('admin.extra.page.update');
        Route::delete('/delete/{page}', [AdminExtraPageController::class,'delete'])->name('admin.extra.page.delete');
    });
    Route::post('/logout',[AdminController::class,'logout'])->name('admin.logout');
});

