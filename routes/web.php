<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WeightTagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutSeviceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route("admin.user.index");
});
Route::get('uploads/')->name("urlPathUploads");

Route::get('auth/login', [LoginController::class, 'viewLogin'])->name('viewLogin');
Route::post('auth/login', [LoginController::class, 'login'])->name('login');
Route::get('auth/logout', LogoutSeviceController::class)->name('logout');




Route::prefix('admin')->name('admin.')->middleware(['auth:web', "checkLogin"])->group(function () {

    Route::prefix('user')->name('user.')->controller(UserController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //find and get data
        Route::post('get-users', 'getUsers')->name('getUsers');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });


    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //find and get data
        Route::post('get-products', 'getProducts')->name('getProducts');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('warehouse')->name('warehouse.')->controller(WarehouseController::class)->group(function () {
        //view
        Route::get('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');


        //find and get data
        Route::post('get-imports', 'getImports')->name('getImports');
        Route::post('find-import', 'findImport')->name('findImport');
        Route::post('get-export', 'getExports')->name('getExports');

        //create 
        Route::post('store-import', 'importStore')->name('importStore');
        Route::post('store-export', 'exportStore')->name('exportStore');


        // edit and update import
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });




    Route::prefix('other')->name('other.')->group(function () {
        Route::prefix('supplier')->name('supplier.')->controller(SupplierController::class)->group(function () {
            //view
            Route::get('index', 'index')->name('index');
            //create 
            Route::post('store', 'store')->name('store');

            //edit and update
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');

            //destroy
            Route::get('destroy/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('weight-tag')->name('weight-tag.')->controller(WeightTagController::class)->group(function () {
            //view
            Route::get('index', 'index')->name('index');
            //create 
            Route::post('store', 'store')->name('store');
            //destroy
            Route::get('destroy/{id}', 'destroy')->name('destroy');
        });



    });

});
