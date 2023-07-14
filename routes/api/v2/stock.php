<?php


use App\Domains\Stock_Management\Http\Controllers\ProductBoxController;
use App\Domains\Stock_Management\Http\Controllers\DashboardController;
use App\Domains\Stock_Management\Http\Controllers\ProductController;
use App\Domains\Stock_Management\Http\Controllers\ProductLotController;
use App\Domains\Stock_Management\Http\Controllers\ProductVariantController;
use App\Domains\Stock_Management\Http\Controllers\ProductVariantAttributeController;
use App\Domains\Stock_Management\Http\Controllers\ProductVariantAttributeValueController;
use App\Domains\Stock_Management\Http\Controllers\ReportController;
use App\Domains\Stock_Management\Http\Controllers\RequestTransferController;
use App\Domains\Stock_Management\Http\Controllers\StockDataController;
use App\Domains\Stock_Management\Http\Controllers\TransferController;
use App\Domains\Stock_Management\Http\Controllers\WarehouseController;
use App\Domains\Stock_Management\Http\Controllers\WarehouseOwnersController;
use App\Domains\Stock_Management\Http\Resources\ProductPriceResource;
use App\Domains\Stock_Management\Models\ProductBox;
use App\Domains\Stock_Management\Models\ProductPrice;
use App\Events\hello;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Http\Request;
//PRODUCT
Route::group([
    'prefix' => 'v2',
    'as' => 'v2.',
], function () {
    Route::get('/broadcast', function(){
        return hello::dispatch();
    });
    Route::get('/all_role', function(){
        return response()->json(SpatieRole::get());
    });
    // Route::get('reports/stock-summary', [ReportController::class, 'stock_summary']);
    Route::get('reports/stock-summary', [ReportController::class, 'stockSummary']);
    Route::get('reports/stock-yearly', [ReportController::class, 'yearlyReport']);
    Route::get('reports/export-stock-yearly/{year}', [ReportController::class, 'yearlyExport']);
    Route::get('reports/export-stock-yearly_all', [ReportController::class, 'yearlyExportAll']);
    // Route::get('reports/stock-movement', [ReportController::class, 'stockMovement']);
    Route::get('reports/stock-movement', [ReportController::class, 'getStockMovementGoods']);
    Route::get('reports/all-stock', [ReportController::class, 'allProducts']);
    Route::get('reports/by-warehouse', [ReportController::class, 'byWarehouse']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::group([
        'prefix' => 'product',
        'as' => 'product.',
    ], function(){
        #api/v2/product/bottle
        Route::apiResource('bottle', ProductController::class, ['parameters' => ['bottle' => 'bottle']]);
        # api/v2/product/variant
        Route::apiResource('box', ProductBoxController::class, ['parameters' => ['box' => 'box']]);
        # api/v2/product/lot
        Route::apiResource('lot', ProductLotController::class, ['parameters' => ['lot' => 'lot']]);
        Route::get('/page', [ProductLotController::class, 'pagination']);
        Route::get('/box_all', [ProductBoxController::class, 'get_all']);
        Route::apiResource('variant', ProductVariantController::class, ['parameters' => ['variant' => 'variant']]);
        # api/v2/product/attribute
        Route::apiResource('attribute', ProductVariantAttributeController::class, ['parameters' => ['attribute' => 'attribute']]);
        # api/v2/product/value
        Route::apiResource('value', ProductVariantAttributeValueController::class, ['parameters' => ['value' => 'value']]);
        Route::get('/price', function(Request $request){
            if($request->has('product_code')){
                return response()->json(ProductPrice::where('product_code', $request->product_code)->get());
            }else{
                return response()->json(ProductPriceResource::collection(ProductPrice::get()));
            }
        });
        # api/v2/product/almost_exp
        Route::get('/almost_exp', function(){
            $month = Carbon::now()->addMonth(2);
            $data =  ProductBox::join('products', 'products.product_code', '=', 'product_boxes.product_code')
                    ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
                    ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
                    ->whereBetween('exp_date', [Carbon::now(), $month])
                    ->WhereYear('exp_date',$month->year)->get();
            return response()->json($data);
        });
        # api/v2/product/expired
        Route::get('/expired', function(){
            $data =  ProductBox::join('products', 'products.product_code', '=', 'product_boxes.product_code')
            ->join('product_lots', 'product_lots.lot_code', '=', 'product_boxes.lot_code')
            ->join('warehouses', 'warehouses.warehouse_code', '=', 'product_lots.warehouse_code')
            ->where('exp_date', '<', Carbon::now())->get();

            return response()->json($data);
        });
    });
    // api/v2/stock
    Route::group([
        'prefix' => 'stock',
        'as' => 'stock.'
    ], function(){
        Route::get('available', [StockDataController::class, 'available_stock']);
        Route::get('check', [StockDataController::class, 'check_availability']);
        Route::get('data', [StockDataController::class, 'data']);
    });
    // api/v2/warehouse
    Route::apiResource('warehouse', WarehouseController::class, ['parameters' => ['warehouse' => 'warehouse']]);

    //api/v2/owner
    Route::get('/owner', [WarehouseOwnersController::class,'getUser']);
    Route::group([ 
        'prefix' => 'operation',
        'as' => 'operation.'
    ], function(){
        Route::group([
            'prefix' => 'request_tran',
            'as' => 'request_tran.'
        ], function(){
            Route::get('/', [RequestTransferController::class, 'index']);
            Route::post('/new', [RequestTransferController::class, 'store']);
            Route::patch('/submit/{id}', [RequestTransferController::class, 'submit']);
            Route::patch('/confirm/{id}', [RequestTransferController::class, 'confirm']);
            Route::patch('/reject/{id}', [RequestTransferController::class, 'reject']);
            Route::patch('/update/{id}', [RequestTransferController::class, 'update']);
            // Route::group(['middleware' => ['auth', 'in_group:group_name']], function () {
            // });
            });
        Route::group([
            'prefix' => 'transfer',
            'as' => 'transfer.'
        ], function(){
            Route::get('/', [TransferController::class, 'index']);
            Route::post('/new/{id}', [TransferController::class, 'transfer']);
            // Route::group(['middleware' => ['auth', 'in_group:group_name']], function () {
            // });
            });
        Route::group([
            'prefix' => 'receive',
            'as' => 'receive.'
        ], function(){
            Route::post('/new/{id}', [RequestTransferController::class, 'receive']);
            // Route::group(['middleware' => ['auth', 'in_group:group_name']], function () {
            // });
            });
    });

});