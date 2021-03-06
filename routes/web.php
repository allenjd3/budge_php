<?php

use App\Actions\DeleteItemAction;
use App\Actions\StoreMonthAction;
use App\Actions\UpdateItemAction;
use App\Actions\StoreNewItemAction;
use App\Actions\ShowDashboardAction;
use App\Actions\StoreCategoryAction;
use App\Actions\DeleteCategoryAction;
use App\Actions\StorePaychecksAction;
use App\Actions\UpdateCategoryAction;
use Illuminate\Support\Facades\Route;
use App\Actions\DeletePaychecksAction;
use App\Actions\UpdatePaychecksAction;
use App\Actions\ParseTransactionImport;
use App\Actions\DeleteTransactionAction;
use App\Actions\UpdateTransactionAction;
use App\Actions\ImportTransactionsAction;
use App\Actions\SortImportedTransactions;
use App\Actions\StoreNewTransactionAction;
use App\Actions\ModifyMonthlyPlannedAction;
use App\Actions\ShowDashboardByMonthAction;
use App\Actions\GetAllMonthsByUserTeamAction;
use App\Actions\ConfirmParseTransactionImport;
use App\Actions\DeleteImportTransactionAction;
use App\Actions\StoreImportTransactionsAction;
use App\Actions\CreateTransactionByMonthAction;
use App\Actions\QueryMonthByMonthAndYearAction;
use App\Actions\UpdateSortImportedTransactions;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', ShowDashboardAction::class)->name('dashboard');

    Route::get('/dashboard/{m}', ShowDashboardByMonthAction::class)->name('dashboard-month');

    Route::get('/create-transaction/{month_id}', CreateTransactionByMonthAction::class);

    Route::post('/transactions', StoreNewTransactionAction::class);

    Route::delete('/transactions/{transaction}', DeleteTransactionAction::class);

    Route::put('/transactions/{transaction}', UpdateTransactionAction::class);

    Route::get('/month/{month}/transactions/import', ImportTransactionsAction::class);

    Route::post('/month/{month}/transactions/import', StoreImportTransactionsAction::class);

    Route::get('/month/{month}/transactions/import/{csvimport}', ParseTransactionImport::class);

    Route::get('/month/{month}/transactions/import/{csvimport}/confirm', ConfirmParseTransactionImport::class);

    Route::get('/month/{month}/transactions/sort', SortImportedTransactions::class);

    Route::put('/month/{month}/transactions/sort', UpdateSortImportedTransactions::class);

    Route::delete('/month/{month}/transactions/import/{csvimport}/delete', DeleteImportTransactionAction::class);

    Route::post('/items', StoreNewItemAction::class);

    Route::put('/items/{item}', UpdateItemAction::class);

    Route::delete('/items/{item}', DeleteItemAction::class);

    Route::post('/categories', StoreCategoryAction::class);

    Route::put('/categories/{category}', UpdateCategoryAction::class);

    Route::delete('/categories/{category}', DeleteCategoryAction::class);

    Route::get('/months', GetAllMonthsByUserTeamAction::class);

    Route::get('/month/{m}/year/{year}', QueryMonthByMonthAndYearAction::class);

    Route::post('/months', StoreMonthAction::class);

    Route::post('/modify-planned', ModifyMonthlyPlannedAction::class);

    Route::post('/paychecks', StorePaychecksAction::class);

    Route::put('/paychecks/{paycheck}', UpdatePaychecksAction::class);

    Route::delete('/paychecks/{paycheck}', DeletePaychecksAction::class);
});
