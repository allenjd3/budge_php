<?php

use App\Actions\CreateTransactionByMonthAction;
use App\Actions\DeleteCategoryAction;
use App\Actions\DeleteItemAction;
use App\Actions\DeletePaychecksAction;
use App\Actions\DeleteTransactionAction;
use App\Actions\GetAllMonthsByUserTeamAction;
use App\Actions\ModifyMonthlyPlannedAction;
use App\Actions\QueryMonthByMonthAndYearAction;
use App\Actions\ShowDashboardAction;
use App\Actions\ShowDashboardByMonthAction;
use App\Actions\StoreCategoryAction;
use App\Actions\StoreMonthAction;
use App\Actions\StoreNewItemAction;
use App\Actions\StoreNewTransactionAction;
use App\Actions\StorePaychecksAction;
use App\Actions\UpdateCategoryAction;
use App\Actions\UpdateItemAction;
use App\Actions\UpdatePaychecksAction;
use App\Actions\UpdateTransactionAction;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/create-transaction/{month_id}', CreateTransactionByMonthAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/transactions', StoreNewTransactionAction::class);

Route::middleware(['auth:sanctum', 'verified'])->delete('/transactions/{transaction}', DeleteTransactionAction::class);

Route::middleware(['auth:sanctum', 'verified'])->put('/transactions/{transaction}', UpdateTransactionAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/items', StoreNewItemAction::class);

Route::middleware(['auth:sanctum', 'verified'])->put('/items/{item}', UpdateItemAction::class);

Route::middleware(['auth:sanctum', 'verified'])->delete('/items/{item}', DeleteItemAction::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/months', GetAllMonthsByUserTeamAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/categories', StoreCategoryAction::class );

Route::middleware(['auth:sanctum', 'verified'])->post('/categories/{category}', UpdateCategoryAction::class);

Route::middleware(['auth:sanctum', 'verified'])->delete('/categories/{category}', DeleteCategoryAction::class);

Route::middleware(['auth:sanctum','verified'])->get('/month/{m}/year/{year}', QueryMonthByMonthAndYearAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/months', StoreMonthAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/modify-planned', ModifyMonthlyPlannedAction::class);

Route::middleware(['auth:sanctum', 'verified'])->post('/paychecks', StorePaychecksAction::class);

Route::middleware(['auth:sanctum', 'verified'])->put('/paychecks/{paycheck}', UpdatePaychecksAction::class);

Route::middleware(['auth:sanctum', 'verified'])->delete('/paychecks/{paycheck}', DeletePaychecksAction::class);
