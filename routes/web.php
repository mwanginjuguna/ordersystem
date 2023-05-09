<?php

use App\Http\Controllers\ProfileController;
use App\Models\AcademicLevel;
use App\Models\Currency;
use App\Models\File;
use App\Models\Rate;
use App\Models\ServiceType;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Controllers\AcademicLevelController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ServiceTypeController;

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
    return Inertia::render('Welcome', [
        'levels' => AcademicLevel::all(),
        'currencies' => Currency::all(),
        'services' => ServiceType::all(),
        'rates' => Rate::all(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/email-test', function () {
    return view('welcome');
})->name('email-templates');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'A')
    {
        return redirect()->route('admin');
    }
    $orders = \App\Models\Order::query()
        ->where('user_id', '=', auth()->user()->id)
        ->latest()
        ->limit(3)
        ->get();
    return Inertia::render('Dashboard', [
        'orders' => $orders
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    $orders = \App\Models\Order::query()
        ->latest()->limit(5)->get();
    return Inertia::render('Admin/Index', [
        'orders' => $orders
    ]);
})->name('admin')->middleware('admin');

Route::middleware('admin')->group( function () {
    Route::name('admin.')->group(function () {
        Route::controller(AcademicLevelController::class)->group(function () {
            Route::get('/admin/levels', 'index')->name('levels');
            Route::post('/admin/levels', 'store')->name('levels.add');
            Route::delete('/admin/levels/{id}', 'destroy')->name('levels.delete');
        });

        Route::controller( SubjectController::class)->group(function () {
            Route::get('/admin/subjects', 'index')->name('subjects');
            Route::post('/admin/subjects', 'store')->name('subjects');
            Route::delete('/admin/subjects/{id}', 'destroy')->name('subject');
        });

        Route::controller( ServiceTypeController::class)->group(function () {
            Route::get('/admin/services', 'index')->name('services');
            Route::post('/admin/services', 'store')->name('services');
            Route::delete('/admin/services/{id}', 'destroy')->name('service');
        });

        Route::controller( \App\Http\Controllers\SpacingController::class)->group(function () {
            Route::get('/admin/spacings', 'index')->name('spacings');
            Route::post('/admin/spacings', 'store')->name('spacings');
            Route::delete('/admin/spacings/{id}', 'destroy')->name('spacing');
        });

        Route::controller( \App\Http\Controllers\ReferencingStyleController::class)->group(function () {
            Route::get('/admin/styles', 'index')->name('styles');
            Route::post('/admin/styles', 'store')->name('styles');
            Route::delete('/admin/styles/{id}', 'destroy')->name('style');
        });

        Route::controller( \App\Http\Controllers\AdditionalFeaturesController::class)->group(function () {
            Route::get('/admin/extras', 'index')->name('extras');
            Route::post('/admin/extras', 'store')->name('extras');
            Route::delete('/admin/extras/{id}', 'destroy')->name('extra');
        });

        Route::controller( \App\Http\Controllers\LanguageController::class)->group(function () {
            Route::get('/admin/languages', 'index')->name('languages');
            Route::post('/admin/languages', 'store')->name('languages');
            Route::delete('/admin/languages/{id}', 'destroy')->name('language');
        });

        Route::controller( \App\Http\Controllers\RateController::class)->group(function () {
            Route::get('/admin/pricings', 'index')->name('pricings');
            Route::post('/admin/pricings', 'store')->name('pricings');
            Route::delete('/admin/pricing/{id}', 'destroy')->name('pricing');
        });

        Route::controller( \App\Http\Controllers\CurrencyController::class)->group(function () {
            Route::get('/admin/currencies', 'index')->name('currencies');
            Route::post('/admin/currencies', 'store')->name('currencies');
            Route::delete('/admin/currencies/{id}', 'destroy')->name('currency');
        });

        Route::controller( \App\Http\Controllers\DiscountController::class)->group(function () {
            Route::get('/admin/discounts', 'index')->name('discounts');
            Route::post('/admin/discounts', 'store')->name('discounts');
            Route::delete('/admin/discounts/{id}', 'destroy')->name('discount');
        });

        Route::controller( \App\Http\Controllers\WriterCategoryController::class)->group(function () {
            Route::get('/admin/writer_categories', 'index')->name('writer_categories');
            Route::post('/admin/writer_categories', 'store')->name('writer_categories');
            Route::delete('/admin/writer_category/{id}', 'destroy')->name('writer_category');
        });
        // Admin Orders
        Route::controller(\App\Http\Controllers\OrderController::class)->group(function () {
            Route::post('/admin/orders/new', 'store')->name('orders.new');
            Route::get('/admin/orders/order/{id}', 'show')->name('orders.show');
            Route::post('/admin/orders/order/{id}', 'update')->name('orders.show');
            Route::patch('/admin/orders/order/complete/{id}', 'markCompleted')->name('orders.complete');
            Route::patch('/admin/orders/order/cancel/{id}', 'markCancelled')->name('orders.cancel')
                ->middleware('admin');
            Route::get('admin/orders/file/{id}', function ($id) {
                $file = File::findOrFail($id);
                //$path = storage_path().'/app/orders/'.$file->name;
                $path2 = Storage::disk('local')->path('orders\\'.$file->name);
                //$content = file_get_contents($path2);
                //dd(response()->download($path2));
                return response()->download($path2);
            })->name('files.download');
            Route::post('admin/orders/order/{id}/upload-file', 'uploadFiles')->name('orders.upload-file');
            Route::post('/admin/orders/order/revision/{id}', 'requestRevision')->name('orders.revisionRequest');
            Route::patch('/admin/orders/order/extend/{id}', 'extendDeadline')->name('orders.extend');
            Route::patch('/admin/orders/order/assign/{id}', 'assignWriter')->name('orders.assign');
            Route::patch('/admin/orders/order/dispute/{id}', 'disputeOrder')->name('orders.dispute');
            Route::get('/admin/orders/recents', 'recents')->name('orders.recents');
            Route::delete('/admin/orders/order/{id}', 'destroy')->name('orders.delete');
            Route::get('/admin/orders/cancelled', 'cancelled')->name('orders.cancelled');
            Route::get('/admin/orders/submitted', 'submitted')->name('orders.submitted');
            Route::get('/admin/orders/running', 'running')->name('orders.running');
            Route::get('/admin/orders/completed', 'completed')->name('orders.completed');
            Route::get('/admin/orders/revision', 'revision')->name('orders.revision');
            Route::get('/admin/orders/disputed', 'disputed')->name('orders.disputed');
            Route::get('/admin/orders/pending', 'pending')->name('orders.pending');
        });
    });
});


Route::get('/orders/new', [\App\Http\Controllers\ClientOrdersController::class, 'create'])->name('orders.new');
Route::post('/orders/new', [\App\Http\Controllers\ClientOrdersController::class, 'store'])->name('orders.new');

Route::middleware('auth')->group(function () {
    Route::post(
        'orders/order/{id}/upload-file',
        [\App\Http\Controllers\OrderController::class, 'uploadFiles'])
        ->name('order.submit-files');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(\App\Http\Controllers\ClientOrdersController::class)->group(function () {
        // Route::get('/orders/new', 'create')->name('orders.new');
        Route::get('orders', 'index')->name('client.orders');
        Route::get('orders/order/{id}', 'show')->name('orders.show');
        Route::get('orders/preview/{id}', 'preview')->name('orders.preview');
        Route::post('orders/order/{id}/upload-file', 'uploadFiles')->name('orders.upload-file');
        Route::get('admin/orders/file/{id}', function ($id) {
            $file = File::findOrFail($id);
            $path2 = Storage::disk('local')->path('orders\\'.$file->name);
            return response()->download($path2);
        })->name('files.download');

        Route::patch('/orders/order/complete/{id}', 'markCompleted')->name('orders.complete');
        Route::post('/orders/order/revision/{id}', 'requestRevision')->name('orders.revisionRequest');
        Route::patch('/orders/order/extend/{id}', 'extendDeadline')->name('orders.extend');
        Route::patch('/orders/order/dispute/{id}', 'disputeOrder')->name('orders.dispute');
        Route::get('/orders/recents', 'recents')->name('orders.recents');
        Route::delete('/orders/order/{id}', 'destroy')->name('orders.delete');
        Route::get('/orders/cancelled', 'cancelled')->name('orders.cancelled');
        Route::get('/orders/submitted', 'submitted')->name('orders.submitted');
        Route::get('/orders/running', 'running')->name('orders.running');
        Route::get('/orders/completed', 'completed')->name('orders.completed');
        Route::get('/orders/revision', 'revision')->name('orders.revision');
        Route::get('/orders/disputed', 'disputed')->name('orders.disputed');
        Route::get('/orders/pending', 'pending')->name('orders.pending');
    });

});

Route::controller(\App\Http\Controllers\PayPalPaymentsController::class)->group(function () {
    Route::get('/orders/order/make-payment/{id}', 'pay')->name('make-payment');
    Route::get('/orders/order/cancel-payment/{id}', 'cancel')->name('cancel-payment');
    Route::get('/orders/order/payment-success/{id}', 'success')->name('payment-success');
});

require __DIR__.'/auth.php';
