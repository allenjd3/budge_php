<?php

namespace App\Actions;

use App\BudgeIt\Budge;
use App\Feature\BudgetMath;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class StoreNewTransactionAction extends Action
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
        return [
            'name'=>'required',
            'item_id'=>'required|numeric',
            'spent_date'=>'required|date',
            'spent'=>'required|numeric'
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        $transaction = new Transaction;
        $transaction->name = $this->name;
        $transaction->item_id = $this->item_id;
        $transaction->month_id = $this->month_id;
        $transaction->spent = $this->getSpent()->getInteger();
        $transaction->spent_date = $this->spent_date;
        $transaction->save();

        $item = $transaction->item;

        $item->remaining = $this->getPlannedFromItem($item)->subBudge($this->getTransactionsSpentFromItem($item))
                                             ->getInteger();
        $item->save();

        return redirect()->back();
    }

    public function getSpent() : Budge
    {
        return new Budge($this->spent);
    
    }

    public function getPlannedFromItem($item) : Budge
    {
        return new Budge($item->planned, true);
    
    }

    public function getTransactionsSpentFromItem($item) : Budge
    {
        return new Budge($item->transactions->sum('spent'), true);
    }
}
