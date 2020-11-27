<?php

use App\Actions\ShowDashboardAction;
use App\Actions\ShowDashboardByMonthAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowDashboardAction::class)->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/{m}', ShowDashboardByMonthAction::class)->name('dashboard-month');

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction/{month_id}', function($month_id) {

    $month = App\Models\Month::find($month_id);
    $items = App\Models\Item::where('month_id','=',$month->id)->get();
    $transactions = App\Models\Transaction::where('month_id','=', $month->id)->with('item')->get();
    
    return Inertia\Inertia::render('ItemTransactions', compact([ 'month', 'items', 'transactions' ]));
});

Route::middleware(['auth:sanctum', 'verified'])->post('/transactions', function(Request $request) {
    $request->validate([
        'name'=>'required',
        'item_id'=>'required|numeric',
        'spent_date'=>'required|date',
        'spent'=>'required|numeric'
    ]);
    $transaction = new App\Models\Transaction;
    $transaction->name = $request->name;
    $transaction->item_id = $request->item_id;
    $transaction->month_id = $request->month_id;
    $transaction->spent = $request->spent;
    $transaction->spent_date = $request->spent_date;
    $transaction->save();

    $item = $transaction->item;

    $item->remaining = ( $item->remaining - $transaction->spent )/100;
    $item->save();

    return redirect()->back();


});
Route::middleware(['auth:sanctum', 'verified'])->delete('/transactions/{transaction}', function($transaction, Request $request) {
    $transaction = App\Models\Transaction::find($transaction);
    $item = $transaction->item;
    $item->remaining = ( $item->remaining + $transaction->spent )/100;
    $item->save();
    $transaction->delete();

    return redirect()->back();

});
Route::middleware(['auth:sanctum', 'verified'])->put('/transactions/{transaction}', function($transaction, Request $request) {
    $transaction = App\Models\Transaction::find($transaction);
    $item = $transaction->item;
    $item->remaining = ($item->remaining + $transaction->spent)/100;

    $transaction->name = $request->transaction['name'];
    $transaction->item_id = $request->transaction['item_id'];
    $transaction->month_id = $request->transaction['month_id'];
    $transaction->spent = $request->transaction['spent'];
    $transaction->spent_date = $request->transaction['spent_date'];
    $transaction->save();


    $item->remaining = ( $item->remaining - $transaction->spent )/100;
    $item->save();

    return redirect()->back();


});

Route::middleware(['auth:sanctum', 'verified'])->post('/items', function(Request $request){


    $request->validate([
        'name' =>'required',
        'planned'=>'required|numeric',
        'category_id'=>'required'
    ]);
	$item = new App\Models\Item;
	$item->name = $request->name;
	$item->planned = $request->planned;
    $item->remaining = $request->planned;
	$item->is_fund = $request->is_fund;
	$item->month_id = $request->month_id;
	$item->category_id = $request->category_id;
	$item->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->put('/items/{item}', function($item, Request $request){
    $request->validate([
        'name' =>'required',
        'planned'=>'required|numeric',
        'category_id'=>'required'
    ]);

	$item = App\Models\Item::find($item);

    $calculatedRemaining = $item->planned - $item->remaining;

	$item->name = $request->name;
	$item->planned = $request->planned;
    $item->remaining = $request->planned - $calculatedRemaining/100;
	$item->is_fund = $request->is_fund;
	$item->month_id = $request->month_id;
	$item->category_id = $request->category_id;
	$item->save();

    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->delete('/items/{item}', function($item, Request $request){

    $item = App\Models\Item::find($item);
    foreach($item->transactions as $transaction){
        $transaction->delete();
    }
    $item->delete();
    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/months', function(){
    $months = Auth::user()->currentTeam->months()->get();
    
    return Inertia\Inertia::render('CreateMonth', compact('months'));
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories', function(Request $request){

    $request->validate([
        'name'=>'required'
    ]);
    $category = new App\Models\Category;
    $category->name = $request->name;
    $category->month_id = $request->month_id;
    $category->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories/{category}', function($category, Request $request){

    $category = App\Models\Category::find($category);
    $category->name = $request->category['name'];
    $category->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->delete('/categories/{category}', function($category, Request $request){

    $category = App\Models\Category::find($category);
    foreach($category->items as $item) {
        foreach($item->transactions as $transaction) {
            $transaction->delete();
        }
        $item->delete();
    }
    $category->delete();

    return redirect()->back();
});
Route::middleware(['auth:sanctum','verified'])->get('/month/{m}/year/{year}', function($m, $year){
    $month = Auth::user()->currentTeam->months()->where('month','=',$m)->where('year','=',$year)->first();
    if( $month === null){
        return redirect('/months');
    }
    return redirect()->route('dashboard-month', ['m'=>$month->id]);

});

Route::middleware(['auth:sanctum', 'verified'])->post('/months', function(Request $request){
    $month = Auth::user()->currentTeam->months()->firstOrNew([
        'month'=>$request->month,
        'year'=>$request->year
    ]);
    $month->team_id = $request->user()->currentTeam->id;
    $month->save();

    if($request->copymonth !== null) {
        $month2 = App\Models\Month::find($request->copymonth);

        if($month2->categories()->exists()) {
            foreach($month2->categories as $category)
            {
                $c = new App\Models\Category();
                $c->name = $category->name;
                $c->month_id = $month->id;
                $c->save();
                if($category->items()->exists()) {
                    foreach($category->items as $item)
                    {
                        $i = new App\Models\Item();
                        $i->name = $item->name;
                        $i->planned = ( $item->planned )/100;
                        
                        $i->is_fund = $item->is_fund;
                        if($item->is_fund) {
                            $i->remaining = ( $item->remaining + $i->planned )/100;
                        }
                        else {
                            $i->remaining = ( $item->planned )/100;
                        }
                        $i->category_id = $c->id;
                        $i->month_id = $month->id;
                        $i->save();
                    }
                }

            }

        } 
    }
     

    return redirect()->route('dashboard-month', ['m'=>$month->id]);
});
Route::middleware(['auth:sanctum', 'verified'])->post('/modify-planned', function(Request $request){
    $month = App\Models\Month::find($request->month_id);
    $month->monthly_planned = $request->monthly_planned;
    $month->save();

    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->post('/paychecks', function(Request $request){
    $request->validate([
       'name'=>'required',
       'payday'=>'required|numeric',
       'pay_date'=>'required|date' 
    ]);
    $paycheck = new App\Models\Paycheck;
    $paycheck->name = $request->name;
    $paycheck->payday = $request->payday;
    $paycheck->pay_date = $request->pay_date;
    $paycheck->month_id = $request->month_id;

    $paycheck->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->put('/paychecks/{paycheck}', function($paycheck, Request $request){
    $paycheck = App\Models\Paycheck::find($paycheck);
    $paycheck->name = $request->paycheck['name'];
    $paycheck->payday = $request->paycheck['payday'];
    $paycheck->pay_date = $request->paycheck['pay_date'];
    $paycheck->month_id = $request->paycheck['month_id'];

    $paycheck->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->delete('/paychecks/{paycheck}', function($paycheck, Request $request){
    $paycheck = App\Models\Paycheck::find($paycheck);
    $paycheck->delete();

    return redirect()->back();
});
