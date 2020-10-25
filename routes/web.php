<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $month = Auth::user()->currentTeam->months()->orderByDesc('id')->with([ 'categories.items', 'paychecks' ])->first();
    if( $month === null){
        return redirect('/months');
    }
    $paid = $month->paychecks->sum('payday');
    
    $itemSum = 0;
    foreach($month->categories as $cat) {
        $itemSum += $cat->items->sum('planned');
    }
    $planning = $month->monthly_planned - $itemSum;
    $tSum = App\Models\Transaction::where('month_id', '=', $month->id)->sum('spent');
    $left = $paid-$tSum;
    
    return Inertia\Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning']));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/{m}', function ($m) {
    $month = Auth::user()->currentTeam->months()->with([ 'categories.items', 'paychecks' ])->find($m);
    $paid = $month->paychecks->sum('payday');
    $itemSum = 0;
    foreach($month->categories as $cat) {
        $itemSum += $cat->items->sum('planned');
    }
    $planning = $month->monthly_planned - $itemSum;
    $tSum = App\Models\Transaction::where('month_id', '=', $month->id)->sum('spent');
    $left = $paid-$tSum;
    
    return Inertia\Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning']));
})->name('dashboard-month');

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction/{month_id}', function($month_id) {

    $month = App\Models\Month::find($month_id);
    $items = App\Models\Item::where('month_id','=',$month->id)->get();
    $transactions = App\Models\Transaction::where('month_id','=', $month->id)->with('item')->get();
    
    return Inertia\Inertia::render('ItemTransactions', compact([ 'month', 'items', 'transactions' ]));
});

Route::middleware(['auth:sanctum', 'verified'])->post('/transactions', function(Request $request) {
    $transaction = new App\Models\Transaction;
    $transaction->name = $request->transaction['name'];
    $transaction->item_id = $request->transaction['item_id'];
    $transaction->month_id = $request->transaction['month_id'];
    $transaction->spent = $request->transaction['spent'];
    $transaction->spent_date = $request->transaction['spent_date'];
    $transaction->save();

    $item = $transaction->item;

    $item->remaining = ( $item->remaining - $transaction->spent )/100;
    $item->save();

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

	$item = new App\Models\Item;
	$item->name = $request->item['name'];
	$item->planned = $request->item['planned'];
    $item->remaining = $request->item['planned'];
	$item->is_fund = $request->item['is_fund'];
	$item->month_id = $request->item['month_id'];
	$item->category_id = $request->item['category_id'];
	$item->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->put('/items/{item}', function($item, Request $request){

	$item = App\Models\Item::find($item);

    $calculatedRemaining = $item->planned - $item->remaining;

	$item->name = $request->item['name'];
	$item->planned = $request->item['planned'];
    $item->remaining = $request->item['planned'] - $calculatedRemaining/100;
	$item->is_fund = $request->item['is_fund'];
	$item->month_id = $request->item['month_id'];
	$item->category_id = $request->item['category_id'];
	$item->save();

    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/months', function(){
    $months = Auth::user()->currentTeam->months()->get();
    
    return Inertia\Inertia::render('CreateMonth', compact('months'));
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories', function(Request $request){

    $category = new App\Models\Category;
    $category->name = $request->category['name'];
    $category->month_id = $request->category['month_id'];
    $category->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories/{category}', function($category, Request $request){

    $category = App\Models\Category::find($category);
    $category->name = $request->category['name'];
    $category->save();

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
                        $i->planned = $item->planned;
                        $i->is_fund = $item->is_fund;
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
    $paycheck = new App\Models\Paycheck;
    $paycheck->name = $request->paycheck['name'];
    $paycheck->payday = $request->paycheck['payday'];
    $paycheck->pay_date = $request->paycheck['pay_date'];
    $paycheck->month_id = $request->paycheck['month_id'];

    $paycheck->save();

    return redirect()->back();
});
