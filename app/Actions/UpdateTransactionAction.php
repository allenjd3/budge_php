<?php

namespace App\Actions;

use App\Models\Transaction;
use Lorisleiva\Actions\Action;

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
        $item->remaining = ($item->remaining + $transaction->spent)/100;

        $transaction->name = $this->name;
        $transaction->item_id = $this->item_id;
        $transaction->month_id = $this->month_id;
        $transaction->spent = $this->spent;
        $transaction->spent_date = $this->spent_date;
        $transaction->save();


        $item->remaining = ( $item->remaining - $transaction->spent )/100;
        $item->save();

        return redirect()->back();

    }
}
