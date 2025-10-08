<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Test routes
Route::get('/test/hello/{name}', [TestController::class, 'hello']);
Route::get('/test/hi/{name}', [TestController::class, 'hi']);
Route::get('/test/high/{name}', [TestController::class, 'high']);

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public routes for testing - remove in production
Route::get('/companies', function () {
    return response()->json([
        'success' => true,
        'message' => 'Companies retrieved successfully',
        'data' => \App\Models\Company::all()
    ]);
});

Route::get('/company/{id?}', function (Request $request, $id=null  ) {

    $company = $id ? \App\Models\Company::with(['venues', 'venues.tables', 'venues.menus','venues.menus.items'])->find($id) : null;

    return response()->json([
        'success' => true,
        'message' => 'Companies retrieved successfully',
        'data' => $company
    ]);
});


Route::get('/venues', function () {
    return response()->json([
        'success' => true,
        'message' => 'Companies retrieved successfully',
        'data' => \App\Models\Venue::all()
    ]);
});


Route::get('/tables', function () {
    return response()->json([
        'success' => true,
        'message' => 'tables retrieved successfully',
        'data' => \App\Models\Table::with('venue')->get()
    ]);
});


Route::get('/menus', function () {
    return response()->json([
        'success' => true,
        'message' => 'tables retrieved successfully',
        'data' => \App\Models\Menu::all()
    ]);
});

// Protected routes - enable after setting up authentication
// Route::middleware(['auth:sanctum'])->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Company routes
    Route::apiResource('companies', CompanyController::class);

    // Venue routes (nested under companies)
    Route::prefix('companies/{company}')->group(function () {
        Route::apiResource('venues', VenueController::class);

        // Venue statistics
        Route::get('venues/{venue}/statistics', [VenueController::class, 'statistics'])
            ->name('venues.statistics');
    });

    // Menu routes (nested under venues)
    Route::prefix('venues/{venue}')->group(function () {
        // Menus
        Route::apiResource('menus', MenuController::class);

        // Menu sections (nested under menus)
        Route::prefix('menus/{menu}')->group(function () {
            Route::apiResource('sections', MenuSectionController::class);
            Route::post('sections/reorder', [MenuSectionController::class, 'reorder']);

            // Menu items (nested under sections)
            Route::prefix('sections/{section}')->group(function () {
                Route::apiResource('items', MenuItemController::class);
                Route::post('items/reorder', [MenuItemController::class, 'reorder']);
                Route::put('items/{item}/availability', [MenuItemController::class, 'updateAvailability']);
            });
        });

        // Tables
        Route::apiResource('tables', TableController::class);
        Route::post('tables/{table}/generate-qr', [TableController::class, 'generateQrCode']);

        // Orders
        Route::apiResource('orders', OrderController::class);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::post('orders/{order}/items', [OrderController::class, 'addItem']);
        Route::put('orders/{order}/items/{item}/status', [OrderController::class, 'updateItemStatus']);
        Route::get('kitchen/orders', [OrderController::class, 'getKitchenOrders']);
        Route::get('tables/active', [OrderController::class, 'getActiveTables']);
    });

    // Products (global, not nested)
    Route::apiResource('products', ProductController::class);
    Route::get('products/search', [ProductController::class, 'search']);
    Route::put('products/{product}/status', [ProductController::class, 'updateStatus']);
// }); // Uncomment this when enabling authentication
