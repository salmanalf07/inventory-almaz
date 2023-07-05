<?php

use App\Http\Controllers\Akun;
use App\Http\Controllers\Application as ControllersApplication;
use App\Http\Controllers\BensinTol;
use App\Http\Controllers\Car;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Driver;
use App\Http\Controllers\EarlyStock;
use App\Http\Controllers\HistoryPart;
use App\Http\Controllers\Invoice;
use App\Http\Controllers\JenisPengeluaran;
use App\Http\Controllers\Order as ControllersOrder;
use App\Http\Controllers\PackingTransaction;
use App\Http\Controllers\PartIn;
use App\Http\Controllers\Parts;
use App\Http\Controllers\Pengeluaran as ControllersPengeluaran;
use App\Http\Controllers\PettyCash;
use App\Http\Controllers\Production;
use App\Http\Controllers\ProductionStd;
use App\Http\Controllers\SJ;
use App\Http\Controllers\Stock as ControllersStock;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\Umakan;
use App\Http\Controllers\User;
use App\Imports\CustomersImport;
use App\Models\Akun as ModelsAkun;
use App\Models\Application;
use App\Models\Car as ModelsCar;
use App\Models\Customer as ModelsCustomer;
use App\Models\DetailOrder;
use App\Models\DetailPartIn;
use App\Models\DetailSJ;
use App\Models\DetailTransaction;
use App\Models\Driver as ModelsDriver;
use App\Models\Invoice as ModelsInvoice;
use App\Models\JenisPengeluaran as ModelsJenisPengeluaran;
use App\Models\NgTransaction;
use App\Models\Order;
use App\Models\PartIn as ModelsPartIn;
use App\Models\Parts as ModelsParts;
use App\Models\Pengeluaran;
use App\Models\ProductionStd as ModelsProductionStd;
use App\Models\SJ as ModelsSJ;
use App\Models\Stock;
use App\Models\TrackSj;
use App\Models\Transaction as ModelsTransaction;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //part_in
    $today = ModelsPartIn::select('id')->where('date_in', date("Y-m-d"))->get();
    $month = ModelsPartIn::select('id')->whereMonth('date_in', date("m"))->get();
    $data = DetailPartIn::with('PartIn', 'Parts.customer');
    $data->whereIn("partin_id", $today->toArray());
    $part = $data->get();
    $rpmonth = DetailPartIn::whereIn("partin_id", $month->toArray())->sum('total_price');
    $rptoday = DetailPartIn::whereIn("partin_id", $today->toArray())->sum('total_price');
    //out
    $todayoutt = ModelsSJ::select('id')->where('date_sj', date("Y-m-d"))->get();
    $monthoutt = ModelsSJ::select('id')->where('status', '!=', "BAYAR_RETUR")->whereMonth('date_sj', date("m"))->get();
    $monthout = DetailSJ::whereIn("sj_id", $monthoutt->toArray())->sum('total_price');
    $todayout = DetailSJ::whereIn("sj_id", $todayoutt->toArray())->sum('total_price');
    //order booking
    $orderyearr = ModelsSJ::select('id')->where([
        ['booking_year', date("Y")],
        ['status', '!=', "BAYAR_RETUR"]
    ])->get();
    $orderyear = DetailSJ::select('total_price')->whereIn("sj_id", $orderyearr->toArray())->sum('total_price');
    $ordermonthh = ModelsSJ::select('id')->where([
        ['booking_month', '=', date("m")],
        ['booking_year', '=', date("Y")],
        ['status', '!=', "BAYAR_RETUR"]
    ])->get();
    $ordermonth = DetailSJ::select('total_price')->whereIn("sj_id", $ordermonthh->toArray())->sum('total_price');
    //production
    $Production = DetailTransaction::with('Transaction', 'Part.customer')
        ->whereHas('Transaction', function ($query) {
            $query->whereDate('date_transaction', date("Y-m-d"));
        })->get();
    $ProdToday = ModelsTransaction::select('id')->where('date_transaction', date("Y-m-d"))->count();
    $ProdMonth = ModelsTransaction::select('id')->whereMonth('date_transaction', date("m"))->count();
    if (Auth::user()->role == "ADMIN") {
        return view('dashboard-admin', [
            'part' => $part,
            'valuetoday' => $rptoday, 'valuemonth' => $rpmonth,
            'todayout' => $todayout, 'monthout' => $monthout,
            'ordermonth' => $ordermonth, 'orderyear' => $orderyear,
            'production' => $Production, 'prodtoday' => $ProdToday, 'prodmonth' => $ProdMonth

        ]);
    }
    return view('dashboard', [
        'part' => $part,
        'valuetoday' => $rptoday, 'valuemonth' => $rpmonth,
        'todayout' => $todayout, 'monthout' => $monthout,
        'ordermonth' => $ordermonth, 'orderyear' => $orderyear,
        'production' => $Production, 'prodtoday' => $ProdToday, 'prodmonth' => $ProdMonth

    ]);
});

Route::get('/mesin', [mesin::class, 'index']);
//Route::middleware(['auth:sanctum', 'verified'])->get('/user', [mesin::class, 'index'])->name('user');

Route::middleware(['auth:sanctum', 'verified'])->post('/search_price', function (Request $request) {
    $part = ModelsParts::find($request->id);
    //$part = ModelsParts::where($request->part_id)->first();
    //$total_price = $part->price * str_replace(",", "", $request->qty);
    $total_price = $part->price;
    return response()->json($total_price);
});
//application
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/application', function () {
    return view('/manage/application', ['judul' => "Application"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_apps', [ControllersApplication::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_apps', [ControllersApplication::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_apps', [ControllersApplication::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_apps/{id}', [ControllersApplication::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_apps/{id}', [ControllersApplication::class, 'destroy']);
//production standard
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/productStd', function () {
    return view('/manage/productionStd', ['judul' => "Production Standard"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_productStd', [ProductionStd::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_productStd', [ProductionStd::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_productStd', [ProductionStd::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_productStd/{id}', [ProductionStd::class, 'update']);
//User
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/user', function () {
    return view('/manage/user', ['judul' => "User"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_user', [User::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_user', [User::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_user', [User::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_user/{id}', [User::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update/{id}', [User::class, 'updatee']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_user/{id}', [User::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->get('/user_edit', function () {
    $user = ModelsUser::find(Auth::user()->id);
    return view('/manage/edit_user', ['judul' => "User Edit", 'user' => $user]);
})->name('user_edit');
//Car
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/car', function () {
    return view('/manage/car', ['judul' => "Cars"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_car', [Car::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_car', [Car::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_car', [Car::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_car/{id}', [Car::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_car/{id}', [Car::class, 'destroy']);
//Driver
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/driver', function () {
    return view('/manage/driver', ['judul' => "Drivers"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_driver', [Driver::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_driver', [Driver::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_driver', [Driver::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_driver/{id}', [Driver::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_driver/{id}', [Driver::class, 'destroy']);
//customer
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/customer', function () {
    return view('/MasterData/customer', ['judul' => "Customer"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_customer', [Customer::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_customer', [Customer::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_customer', [Customer::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_customer/{id}', [Customer::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_customer/{id}', [Customer::class, 'destroy']);
Route::post('/import_customer', function () {
    Excel::import(new CustomersImport, request()->file('file'));
    return 'success!';
});
//part
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/parts', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/MasterData/part', ['judul' => "Parts", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_parts', [Parts::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_parts', [Parts::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_parts', [Parts::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_parts/{id}', [Parts::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_parts/{id}', [Parts::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_price', [Parts::class, 'update_price']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_price_bysj', [Parts::class, 'update_price_bysj']);
//history_parts
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/hisparts', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/MasterData/history_part', ['judul' => "History Price Part", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_hisparts', [HistoryPart::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_prices', [HistoryPart::class, 'update_price']);
//part_in
Route::middleware(['auth:sanctum', 'verified'])->get('/partin', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    $part = ModelsParts::select(['part_name', 'id'])->get();
    $order = Order::select(['no_po', 'id'])->get();
    return view('/transaction/partin', ['judul' => "Part IN", 'customer' => $cust, 'part' => $part, 'order' => $order]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_partin', [PartIn::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_partin', [PartIn::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_partin', [PartIn::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_partin/{id}', [PartIn::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_partin/{id}', [PartIn::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->post('/search_part', function (Request $request) {
    $part = ModelsParts::where('cust_id', $request->cust_id)->get();
    return response()->json($part);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/search_order', function (Request $request) {
    $order = Order::where([['cust_id', $request->cust_id], ['status', 'OPEN']])->get();
    return response()->json($order);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/print_partin/{id}', [PartIn::class, 'print_partin']);
//orders
Route::middleware(['auth:sanctum', 'verified'])->get('/orders', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    $part = ModelsParts::select(['part_name', 'id'])->get();
    return view('/transaction/order', ['judul' => "Order", 'customer' => $cust, 'part' => $part]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_order', [ControllersOrder::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_order', [ControllersOrder::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_order', [ControllersOrder::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_order/{id}', [ControllersOrder::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_order/{id}', [ControllersOrder::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->get('/print_order/{id}', [ControllersOrder::class, 'print_partin']);
Route::middleware(['auth:sanctum', 'verified'])->post('/count/{id}', [ControllersOrder::class, 'count']);
Route::middleware(['auth:sanctum', 'verified'])->post('/search_progress_po', [ControllersOrder::class, 'progress_po']);
Route::middleware(['auth:sanctum', 'verified'])->post('/reportProgress',  function (Request $request) {
    $get = Order::find($request->id);
    $cust = ModelsCustomer::select(['code', 'id'])->find($get->cust_id);
    return view('/report/r_progressPO', ['judul' => "Report Progress PO", 'id' => $request->id, 'cust' => $cust]);
    //return $request->id;
});
//SJ
Route::middleware(['auth:sanctum', 'verified'])->get('/sj', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    $car = ModelsCar::select(['nopol', 'id'])->get();
    $driver = ModelsDriver::select(['name', 'id'])->get();
    $sj = ModelsSJ::latest()->first();
    return view('/transaction/sj', ['judul' => "Part Out", 'customer' => $cust, 'car' => $car, 'driver' => $driver, 'sj' => $sj]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_sj', [SJ::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_sj', [SJ::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_sj', [SJ::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_sj/{id}', [SJ::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_sj/{id}', [SJ::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/del_part/{id}', [SJ::class, 'destroy_part']);
Route::middleware(['auth:sanctum', 'verified'])->post('/search_part', function (Request $request) {
    $part = ModelsParts::where('cust_id', $request->cust_id)->get();
    return response()->json($part);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/search_invoice', function (Request $request) {
    $invoice = ModelsInvoice::where('cust_id', $request->cust_id)->get();
    return response()->json($invoice);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/tracking', function (Request $request) {
    $tracking = TrackSj::with('user')->where('sj_id', $request->id)->get();
    return response()->json($tracking);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/print_sj', [SJ::class, 'print']);
Route::middleware(['auth:sanctum', 'verified'])->get('/update_pricesj', [SJ::class, 'update_price_sj']);

//Invoice
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/invoices', function () {
    $cust = ModelsCustomer::select(['code', 'top', 'id'])->get();
    $part = ModelsParts::select(['part_name', 'id'])->get();
    $pajak = Application::where('status', 'Active')->first();
    return view('/transaction/invoice', ['judul' => "Invoice", 'customer' => $cust, 'part' => $part, 'pajak' => $pajak]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/detail_order', function (Request $request) {
    $Detailorder = DetailOrder::with('Parts')->where('order_id', $request->order_id)->get();
    return response()->json($Detailorder);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/DetOrder_price', function (Request $request) {
    $DetOrderlorder = DetailOrder::with('Parts')->find($request->id);
    return response()->json($DetOrderlorder);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/jatuh_tempo', function (Request $request) {
    $DetOrderlorder = ModelsCustomer::find($request->customer);
    if ($DetOrderlorder->top > 1) {
        $jatuh_tempo = date('d/m/Y', strtotime('+' . $DetOrderlorder->top . 'days', strtotime(str_replace('/', '-', $request->date)))) . PHP_EOL;
    } else {
        $jatuh_tempo = 0;
    }
    return response()->json($jatuh_tempo);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_invoice', [Invoice::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_invoice', [Invoice::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_invoice', [Invoice::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_invoice/{id}', [Invoice::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_invoice/{id}', [Invoice::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified'])->post('/tt_invoice', [Invoice::class, 'tt_invoice']);
Route::middleware(['auth:sanctum', 'verified'])->post('/tax_invoice', [Invoice::class, 'tax_invoice']);
Route::middleware(['auth:sanctum', 'verified'])->post('/rekap_sj', [Invoice::class, 'rekap_sj']);
//Report
Route::middleware(['auth:sanctum', 'verified', 'report:r_invsout'])->get('/r_invsout', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_invsout', ['judul' => "Report Part In VS Part Out", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/report_invsout', [PartIn::class, 'report_invsout']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_partin'])->get('/r_partin', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_partin', ['judul' => "Report Part In", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified', 'report:r_partoutt'])->get('/r_partoutt', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_partoutt', ['judul' => "Report Part Out", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/report_partin', [PartIn::class, 'report_partin']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_partout'])->get('/r_partinn', function () {
    $user = ModelsUser::get();
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_partinn', ['judul' => "Summary In By Customer", 'customer' => $cust, 'user' => $user]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/summary_partin', [PartIn::class, 'summary_partin']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_partout'])->get('/r_partout', function () {
    $user = ModelsUser::get();
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_partout', ['judul' => "Summary By Customer", 'customer' => $cust, 'user' => $user]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/report_partoutt', [SJ::class, 'report_partoutt']);
Route::middleware(['auth:sanctum', 'verified'])->post('/report_partout', [SJ::class, 'report_partout']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_sumpart'])->get('/r_sumpart', function () {
    $user = ModelsUser::get();
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_partout', ['judul' => "Summary By Part", 'customer' => $cust, 'user' => $user]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/report_sumpart', [SJ::class, 'report_sumpart']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_sumpo'])->get('/r_sumpo', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_sumpo', ['judul' => "Summary By PO", 'customer' => $cust,]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/report_sumpo', [SJ::class, 'report_sumpo']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_sumng'])->get('/r_sumng', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_sumng', ['judul' => "Grafik Summary NG", 'customer' => $cust, 'customers' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/grafik_packing', [Transaction::class, 'grafik_packing']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_order'])->get('/r_order', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_order', ['judul' => "Report Order", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/report_order', [ControllersOrder::class, 'report_order']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_invoice'])->get('/r_invoice', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_invoice', ['judul' => "Report Invoice", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/report_invoice', [Invoice::class, 'report_invoice']);
Route::middleware(['auth:sanctum', 'verified'])->post('/rekap_invoice', [Invoice::class, 'rekap_invoice']);
Route::middleware(['auth:sanctum', 'verified', 'report:tracking_invoice'])->get('/tracking_invoice', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/rekap_inv', ['judul' => "Tracking Invoice", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/track_inv', [SJ::class, 'track_inv']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_production'])->get('/r_production', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_production', ['judul' => "Rekap Production", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/rekap_production', [Transaction::class, 'rekap_production']);
Route::middleware(['auth:sanctum', 'verified', 'report:rekap_inv'])->get('/rekap_inv', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/rekap_inv', ['judul' => "Rekap Invoice", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified', 'report:r_sumprod'])->get('/r_sumprod', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_sumprod', ['judul' => "Grafik Summary Production", 'customer' => $cust,]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/grafik_production', [Production::class, 'grafik_production']);
Route::middleware(['auth:sanctum', 'verified'])->post('/r_ng', [PackingTransaction::class, 'r_ng']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_topinv'])->get('/r_topinv', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/report/r_topinv', ['judul' => "Rekap TOP Invoice", 'customer' => $cust,]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/top_invoice', [Invoice::class, 'topInvoice']);
// Route::middleware(['auth:sanctum', 'verified'])->get('/rekap_sj', function () {
//     return view('/rekap/rekap_sj', ['judul' => "Customer", 'days_count' => 30]);
// });

//PRODUCTION
Route::middleware(['auth:sanctum', 'verified'])->post('/search_prices', function (Request $request) {
    $part = ModelsParts::find($request->id);
    //$total_price = $part->price;
    return response()->json($part);
});
//STOCK
Route::middleware(['auth:sanctum', 'verified'])->get('/stock', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/production/stock', ['judul' => "Early Stock", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_stock', [EarlyStock::class, 'json']);
//STOCK-FG
Route::middleware(['auth:sanctum', 'verified'])->get('/stockfg', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/production/stock', ['judul' => "Stock FG", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_stockfg', [ControllersStock::class, 'json']);
//Prosess
Route::middleware(['auth:sanctum', 'verified'])->get('/process', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/production/process', ['judul' => "Process", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_transaction', [Transaction::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_transaction', [Transaction::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_transaction', [Transaction::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_transaction/{id}', [Transaction::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_transaction/{id}', [Transaction::class, 'destroy']);
//Packing
Route::middleware(['auth:sanctum', 'verified'])->get('/packing', function () {
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    return view('/production/packing', ['judul' => "Packing", 'customer' => $cust]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_packing', [PackingTransaction::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_packing', [PackingTransaction::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_packing', [PackingTransaction::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_packing/{id}', [PackingTransaction::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_packing/{id}', [PackingTransaction::class, 'destroy']);
//production jam kerja
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/production', function () {
    $production = ModelsProductionStd::where('status', 'Active')->first();
    return view('/production/production', ['judul' => "Production Input", 'production' => $production]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_production', [Production::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_production', [Production::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_production', [Production::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_production/{id}', [Production::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_production/{id}', [Production::class, 'destroy']);




//KAS

//Akun
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/akuns', function () {
    return view('/kas/setting/kasAkun', ['judul' => "KAS Akun"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_akun', [Akun::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_akun', [Akun::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_akun', [Akun::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_akun/{id}', [Akun::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_akun/{id}', [Akun::class, 'destroy']);
//End Akun
//Jenis Pengeluaran
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/jenisPengeluaran', function () {
    return view('/kas/setting/JenisPengeluaran', ['judul' => "JenisPengeluaran"]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_jenisPengeluaran', [JenisPengeluaran::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_jenisPengeluaran', [JenisPengeluaran::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_jenisPengeluaran', [JenisPengeluaran::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_jenisPengeluaran/{id}', [JenisPengeluaran::class, 'update']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_jenisPengeluaran/{id}', [JenisPengeluaran::class, 'destroy']);
//End Jenis Pengeluaran
//Bensin Tol
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/bensinTol', function () {
    $jenisPengeluaran = ModelsJenisPengeluaran::where('status', 'ACTIV')->get();
    $akun = ModelsAkun::where('status', 'ACTIV')->get();
    $driver = ModelsDriver::select(['name', 'id'])->get();
    $cust = ModelsCustomer::select(['code', 'id'])->get();
    $car = ModelsCar::select(['nopol', 'id'])->get();
    return view('/kas/bensinTol', ['judul' => "Bensin & Tol", 'jenisPengeluaran' => $jenisPengeluaran, 'akun' => $akun, 'driver' => $driver, 'cust' => $cust, 'car' => $car]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_bensinTol', [BensinTol::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_bensinTol', [BensinTol::class, 'storeBensinTol']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_bensinTol', [BensinTol::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_bensinTol/{id}', [BensinTol::class, 'storeBensinTol']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_bensinTol/{id}', [BensinTol::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_bensinTol'])->get('/r_bensinTol', function () {
    return view('/kas/report/r_bensinTol', ['judul' => "Rekap Kas Bensin & Tol"]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/bensinTolReport', [BensinTol::class, 'bensinTolReport']);
//End Bensin Tol
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/pettyCash', function () {
    $jenisPengeluaran = ModelsJenisPengeluaran::where('status', 'ACTIV')->get();
    $akun = ModelsAkun::where('status', 'ACTIV')->get();
    return view('/kas/pettyCash', ['judul' => "Petty Cash", 'jenisPengeluaran' => $jenisPengeluaran, 'akun' => $akun]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_pettyCash', [PettyCash::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_pettyCash', [PettyCash::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_pettyCash', [PettyCash::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_pettyCash/{id}', [PettyCash::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_pettyCash/{id}', [PettyCash::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_pettyCash'])->get('/r_pettyCash', function () {
    return view('/kas/report/r_pettyCash', ['judul' => "Rekap Petty Cash"]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/pettyCashReport', [PettyCash::class, 'pettyCashReport']);
//End Petty Cash
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/uMakan', function () {
    $jenisPengeluaran = ModelsJenisPengeluaran::where('status', 'ACTIV')->get();
    $akun = ModelsAkun::where('status', 'ACTIV')->get();
    return view('/kas/uMakan', ['judul' => "Uang Makan", 'jenisPengeluaran' => $jenisPengeluaran, 'akun' => $akun]);
});
Route::middleware(['auth:sanctum', 'verified'])->get('/json_uMakan', [Umakan::class, 'json']);
Route::middleware(['auth:sanctum', 'verified'])->post('/store_uMakan', [Umakan::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/edit_uMakan', [Umakan::class, 'edit']);
Route::middleware(['auth:sanctum', 'verified'])->post('/update_uMakan/{id}', [Umakan::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/delete_uMakan/{id}', [Umakan::class, 'destroy']);
Route::middleware(['auth:sanctum', 'verified', 'report:r_uMakan'])->get('/r_uMakan', function () {
    return view('/kas/report/r_uMakan', ['judul' => "Rekap Uang Makan"]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/uMakanReport', [Umakan::class, 'uMakanReport']);
//End Uang Makan
Route::middleware(['auth:sanctum', 'verified', 'report:r_saldoAkhir'])->get('/r_saldoAkhir', function () {
    //bensinTol
    $dataaBensinTol = Pengeluaran::where('month', date("m"))
        ->whereYear('date', date("Y"));
    $bensinTol = $dataaBensinTol->where('typeInput', 'BensinTol')->get();
    $sisaBensinTol = $bensinTol->sum('debit') - $bensinTol->sum('kredit');
    //pettyCash
    $dataaPettyCash = Pengeluaran::where('month', date("m"))
        ->whereYear('date', date("Y"));
    $pettyCash = $dataaPettyCash->where('typeInput', 'PettyCash')->get();
    $sisaPettyCash = $pettyCash->sum('debit') - $pettyCash->sum('kredit');
    //UMakan
    $dataaUMakan = Pengeluaran::where('month', date("m"))
        ->whereYear('date', date("Y"));
    $uMakan = $dataaUMakan->where('typeInput', 'UMakan')->get();
    $sisaUMakan = $uMakan->sum('debit') - $uMakan->sum('kredit');

    $totalSeluruh = $sisaBensinTol + $sisaPettyCash + $sisaUMakan;
    return view('/kas/report/r_saldoAkhir', ['judul' => "Rekap Saldo Akhir", 'sisaBensinTol' => $sisaBensinTol, 'sisaPettyCash' => $sisaPettyCash, 'sisaUMakan' => $sisaUMakan, 'totalSeluruh' => $totalSeluruh]);
});
//r_akunbiaya
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/r_akunBiaya', function () {
    return view('/kas/report/r_akunBiaya', ['judul' => "Rekap Akun Biaya"]);
});
Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->post('/akunBiayaReport', [ControllersPengeluaran::class, 'r_akunBiaya']);


Route::middleware(['auth:sanctum', 'verified', 'admistrator'])->get('/sadm', function () {
    $detsj =  DetailSJ::get();
    foreach ($detsj as $data) {
        $parts = ModelsParts::find($data->part_id);
        if ($parts->sa_dm != null) {
            $sadm = $parts->sa_dm;
        } else {
            $sadm = 0;
        }

        DetailSJ::where(['id' => $data->id])
            ->update([
                'sadm' => $data->qty * $sadm,
            ]);
    }

    $sj = ModelsSJ::get();

    foreach ($sj as $data) {
        $sadm = DetailSJ::where('sj_id', $data->id)->sum('sadm');

        ModelsSJ::where(['id' => $data->id])
            ->update([
                'sadm' => number_format((float)$sadm, 2, '.', ''),
            ]);
    }
    return $sj;
});
