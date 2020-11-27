<?php

namespace App\Actions;

use App\Models\Item;
use App\Models\Month;
use App\Models\Transaction;
use Inertia\Inertia;
use Lorisleiva\Actions\Action;

class CreateTransactionByMonthAction extends Action
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        $month = Month::find($this->month_id);
        $items = Item::where('month_id','=',$month->id)->get();
        $transactions = Transaction::where('month_id','=', $month->id)->with('item')->get();

        return Inertia::render('ItemTransactions', compact([ 'month', 'items', 'transactions' ]));
    }
}
