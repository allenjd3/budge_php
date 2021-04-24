<?php

namespace App\Actions;

use App\Models\Item;
use Inertia\Inertia;
use App\Models\Month;
use Lorisleiva\Actions\Action;

class SortImportedTransactions extends Action
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
        $month = Month::find($this->month);
        $transactions = Item::where('month_id', $month->id)
                            ->where('name', 'Transaction Importer')->first()
                            ->transactions()
                            ->get();

        
        $items = $month->items()->get();
        return Inertia::render('SortTransactions', [
            'transactions' => $transactions,
            'items' => $items,
            'month' => $month
        ]);
    }
}
