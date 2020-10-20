<?php

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
    $month = App\Models\Month::orderByDesc('id')->with('categories.items')->first();
    if( $month === null){
        return redirect('/months');
    }
    return Inertia\Inertia::render('Dashboard', compact(['month']));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard/{m}', function ($m) {
    $month = App\Models\Month::with('categories.items')->find($m);

    return Inertia\Inertia::render('Dashboard', compact(['month']));
})->name('dashboard-month');

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction/{month_id}', function($month_id) {

    $month = App\Models\Month::find($month_id);
    
    return Inertia\Inertia::render('ItemTransactions', compact('month'));
});

Route::middleware(['auth:sanctum', 'verified'])->post('/items', function(Request $request){

	$item = new App\Models\Item;
	$item->name = $request->item['name'];
	$item->planned = $request->item['planned'];
    $item->remaining = $request->item['planned'];
	$item->is_fund = $request->item['is_fund'];
	$item->month_id = $request->item['month_id'];
	$item->category_id = $request->item['category_id'];
	$item->user_id = $request->user()->id;
	$item->save();

    return redirect()->back();
});

Route::middleware(['auth:sanctum', 'verified'])->get('/months', function(){
    $months = App\Models\Month::all();
    
    return Inertia\Inertia::render('CreateMonth', compact('months'));
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories', function(request $request){

    $category = new App\Models\Category;
    $category->name = $request->category['name'];
    $category->user_id = $request->user()->id;
    $category->month_id = $request->category['month_id'];
    $category->save();

    return redirect()->back();
});
Route::middleware(['auth:sanctum','verified'])->get('/month/{month}/year/{year}', function($month, $year){
    $month = App\Models\Month::where('month','=',$month)->where('year','=',$year)->first();
    if( $month === null){
        return redirect('/months');
    }
    return redirect()->route('dashboard-month', ['m'=>$month->id]);

});

Route::middleware(['auth:sanctum', 'verified'])->post('/months', function(Request $request){
    $month = App\Models\Month::firstOrNew([
        'month'=>$request->month,
        'year'=>$request->year
    ]);
    $month->user_id = $request->user()->id;
    $month->save();

    if($request->copymonth !== null) {
        $month2 = App\Models\Month::find($request->copymonth);

        if($month2->categories()->exists()) {
            foreach($month2->categories as $category)
            {
                $c = new App\Models\Category();
                $c->name = $category->name;
                $c->user_id = $category->user_id;
                $c->month_id = $month->id;
                $c->save();
                if($category->items()->exists()) {
                    foreach($category->items as $item)
                    {
                        $i = new App\Models\Item();
                        $i->name = $item->name;
                        $i->planned = $item->planned;
                        $i->is_fund = $item->is_fund;
                        $i->user_id = $item->user_id;
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
