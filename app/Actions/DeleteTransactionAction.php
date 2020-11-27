<?php

namespace App\Actions;

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
        $item->remaining = ( $item->remaining + $transaction->spent )/100;
        $item->save();
        $transaction->delete();

        return redirect()->back();
    }
}
