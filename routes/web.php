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
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction', function() {

    return Inertia\Inertia::render('ItemTransactions');
});

Route::middleware(['auth:sanctum', 'verified'])->post('/items', function(Request $request){

    return Inertia\Inertia::render('Dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/months', function(){
    $months = App\Models\Month::all();
    return Inertia\Inertia::render('CreateMonth', compact('months'));
});

Route::middleware(['auth:sanctum', 'verified'])->post('/months', function(Request $request){
    $month = new App\Models\Month;
    $month->month = $request->month;
    $month->year = $request->year;
    $month->user_id = $request->user()->id;
    $month->save();

    return redirect()->route('dashboard');
});
