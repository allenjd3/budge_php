<?php

namespace App\Actions;

use App\Models\Item;
use Inertia\Inertia;
use App\Models\Month;
use App\Models\Transaction;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Request;

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
        $items = Item::where('month_id','=',$month->id)->latest()->get();
        $thefilter = null;

        if(Request::has('filter')) {
            $filter = Request::get('filter');
            $thefilter = $filter;
            $transactions = Transaction::where('month_id','=', $month->id)->whereHas('item', function($query) use($filter){
                $query->where('name', 'LIKE', '%' . $filter . '%');
            })->with('item')->latest()->paginate(20);
            if(!$transactions->count()){
                return redirect('/create-transaction/' . $month->id)->with('message', 'There are no transactions with that filter.');
            }
        }
        else {
            $transactions = Transaction::where('month_id','=', $month->id)->with('item')->latest()->paginate(20);
        }
        

        return Inertia::render('ItemTransactions', compact([ 'month', 'items', 'transactions', 'thefilter' ]));
    }
}
