<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Transaction;
use Lorisleiva\Actions\Action;
use App\Models\Item;

class UpdateTransactionAction extends Action
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
        $transaction = Transaction::find($this->transaction);
        // This will reset the item so that if we change it it will change the amount on the frontend
        $transaction->name = $this->name;
        $transaction->item_id = $this->item_id;
        $transaction->month_id = $this->month_id;
        $transaction->spent = BudgetMath::init()->setString( $this->spent )->getInteger();
        $transaction->spent_date = $this->spent_date;

        if($transaction->save())
        {
            $item = $transaction->item;

            $item->remaining = BudgetMath::init()->removeValueFromTotal($item->planned, $item->transactions->sum('spent'))->getInteger();
            $item->save();

        }

        // This is the actual updating.


        return redirect()->back();

    }
}
