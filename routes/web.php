<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\ProductImageController; 
use App\Http\Controllers\AboutUsController; 
use App\Http\Controllers\ImageSliderController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceImageController;
use App\Http\Controllers\ContactUsController;

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

 
 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('product-categories', ProductCategoryController::class);
    Route::post('/product-categories/update-order', [ProductCategoryController::class, 'updateOrder'])->name('product-categories.update-order'); 
    Route::post('/product-categories/toggle-status', [ProductCategoryController::class, 'toggleStatus'])->name('product-categories.toggle-status');  
    Route::get('product-categories/{category}/subcategories', [ProductCategoryController::class, 'showSubcategories'])->name('product-categories.subcategories.index');

    Route::get('product-categories/{category}/create_sub', [ProductCategoryController::class, 'createSub'])->name('product-categories.create_sub');
    Route::post('product-categories/{category}/store_sub', [ProductCategoryController::class, 'storeSub'])->name('product-categories.store_sub');
    // Route สำหรับแสดงหน้าแก้ไข subcategory
    Route::get('/product-categories/{category}/subcategories/{subcategory}/edit', [ProductCategoryController::class, 'editSub'])
        ->name('product-categories.subcategories.edit');

    // Route สำหรับอัปเดต subcategory
    Route::put('/product-categories/{category}/subcategories/{subcategory}', [ProductCategoryController::class, 'updateSub'])
        ->name('product-categories.subcategories.update');

    Route::post('/product-categories/update-order-sub', [ProductCategoryController::class, 'updateOrder_sub'])->name('product-categories.update-order-sub'); 
    Route::delete('/product-categories/{categoryId}/subcategories/{subcategoryId}', [ProductCategoryController::class, 'destroySubcategory'])
    ->name('product-categories.subcategories.destroy');



    // Route for Products (Resourceful)
    Route::resource('products', ProductController::class);    
    Route::delete('/product_images/{id}', [ProductImageController::class, 'destroy'])->name('product_images.destroy');
    Route::put('products/{product}/image', [ProductController::class, 'updateImage'])->name('products.update.image');
    Route::post('/products/{product}/images', [ProductImageController::class, 'store'])->name('images.store'); 
    Route::post('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggle-status');  


    Route::get('/aboutus', [AboutUsController::class, 'index'])->name('aboutus.index');
    Route::put('/aboutus/update', [AboutUsController::class, 'update'])->name('aboutus.update');
    Route::put('/aboutus/update-image', [AboutUsController::class, 'updateImage'])->name('aboutus.update.image');

    Route::resource('image_sliders', ImageSliderController::class);
    Route::post('/image_sliders/update-order', [ImageSliderController::class, 'updateOrder'])->name('image_sliders.update-order'); 
    Route::post('/image_sliders/toggle-status', [ImageSliderController::class, 'toggleStatus'])->name('image_sliders.toggle-status');  

    Route::resource('System', SystemController::class);
    Route::post('/System/update-order', [SystemController::class, 'updateOrder'])->name('System.update-order'); 
    Route::post('/System/toggle-status', [SystemController::class, 'toggleStatus'])->name('System.toggle-status');
    
    Route::resource('services', ServiceController::class);      
    Route::post('/services/update-order', [ServiceController::class, 'updateOrder'])->name('services.update-order'); 
    Route::post('/services/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    Route::delete('/images/{id}', [ServiceImageController::class, 'destroy'])->name('service_images.destroy');
    Route::put('services/{services}/image', [ServiceController::class, 'updateImage'])->name('services.update.image');
    Route::post('/services/{services}/images', [ServiceImageController::class, 'store'])->name('service_image.store'); 
    
    
    
    Route::get('/contact-us', [ContactUsController::class, 'edit'])->name('contactus.edit');
    Route::put('/contact-us', [ContactUsController::class, 'update'])->name('contactus.update');
});



require __DIR__.'/auth.php';
