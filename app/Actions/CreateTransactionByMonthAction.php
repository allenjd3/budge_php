<?php

namespace App\Actions;

use App\Models\Item;
use App\Notifications\NoTransactionsFromFilter;
use Inertia\Inertia;
use App\Models\Month;
use App\Models\Transaction;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Request;

class CreateTransactionByMonthAction extends Action
{
    public $message;

    public $filter;

    public function __construct()
    {
        $this->message = null;
        $this->filter = null;
    }

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
        $items = Item::where('month_id', $this->month_id)->latest()->get();

        if (!Request::has('filter')) {
            $transactions = $this->noFilter();
        }
        if (Request::has('filter')) {
            $transactions = $this->hasFilter();
        }
        
        if ($this->message !== null) {
            return Inertia::render('ItemTransactions', [
                'month'=> Month::find($this->month_id),
                'items'=> $items,
                'transactions'=> $transactions,
                'filter'=> $this->filter,
                'userId'=> auth()->user()->id
            ])->with('message', $this->message);
        }

        return Inertia::render('ItemTransactions', [
            'month'=> Month::find($this->month_id),
            'items'=> $items,
            'transactions'=> $transactions,
            'filter'=> $this->filter,
            'userId'=> auth()->user()->id
        ]);
    }

    public function hasFilter()
    {
        $this->filter = Request::get('filter');
        $transactions = Transaction::where('month_id', $this->month_id)->whereHas('item', function ($query) {
            $query->where('name', 'LIKE', '%' . $this->filter . '%');
        })->with('item')->latest()->paginate(20);
        if (!$transactions->count()) {
            $this->filter = null;
            $transactions = Transaction::where('month_id', $this->month_id)->with('item')->latest()->paginate(20);
            $this->message = 'There are no Transactions associated with that Filter';
        }
        return $transactions;
    }

    public function noFilter()
    {
        return Transaction::where('month_id', $this->month_id)->with('item')->latest()->paginate(20);
    }
}
