<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Transaction;
use Lorisleiva\Actions\Action;

class DeleteTransactionAction extends Action
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
        $transaction = Transaction::find($this->transaction);
        $item = $transaction->item;
        $item->remaining = BudgetMath::init()->arraySum([ $item->remaining, $transaction->spent ])->getInteger();
        $item->save();
        $transaction->delete();

        return redirect()->back();
    }
}
