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


    return Inertia\Inertia::render('Dashboard', compact(['month']));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction', function() {

    return Inertia\Inertia::render('ItemTransactions');
});

Route::middleware(['auth:sanctum', 'verified'])->post('/items', function(Request $request){

	$item = new App\Models\Item;
	$item->name = $request->item['name'];
	$item->planned = $request->item['planned'];
	$item->is_fund = $request->item['is_fund'];
	$item->month_id = $request->item['month_id'];
	$item->category_id = $request->item['category_id'];
	$item->user_id = $request->user()->id;
	$item->save();

    return redirect()->route('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/months', function(){
    $months = App\Models\Month::all();
    return Inertia\Inertia::render('CreateMonth', compact('months'));
});
Route::middleware(['auth:sanctum', 'verified'])->post('/categories', function(Request $request){

    $category = new App\Models\Category;
    $category->name = $request->category['name'];
    $category->user_id = $request->user()->id;
    $category->month_id = $request->category['month_id'];
    $category->save();

    return redirect()->route('dashboard');
});
Route::middleware(['auth:sanctum','verified'])->get('/month/{month}/year/{year}', function($month, $year){
    $month = App\Models\Month::where('month','=',$month)->where('year','=',$year)->first();
    if( $month === null){
        return redirect('/months');
    }
    return Inertia\Inertia::render('Dashboard', compact(['month']));

});

Route::middleware(['auth:sanctum', 'verified'])->post('/months', function(Request $request){
    $month = new App\Models\Month;
    $month->month = $request->month;
    $month->year = $request->year;
    $month->user_id = $request->user()->id;
    $month->save();

    return redirect()->route('dashboard');
});
