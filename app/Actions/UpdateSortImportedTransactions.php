<?php

namespace App\Actions;

use App\Models\Item;
use App\BudgeIt\Budge;
use App\Models\Transaction;
use Lorisleiva\Actions\Action;

class UpdateSortImportedTransactions extends Action
{
    public $item;
    public $oldItem;
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
        $this->item = Item::where('name', $this->name)->where('month_id', $this->month_id)->first();
        $month = $this->item->month()->first();
        $transaction = Transaction::where('id', $this->transaction_id)->where('month_id', $this->month_id)->first();
        $this->oldItem = $transaction->item()->first();
        $transaction->item_id = $this->item->id;
        if ($transaction->save()) {
            $this->item->remaining = $this->getItemPlanned()
                                          ->subBudge($this->getTransactionsSum())
                                          ->getInteger();
            $this->item->save();
            $this->oldItem->remaining = $this->getOldItemPlanned()
                                            ->subBudge($this->getOldItemTransactionsSum())
                                            ->getInteger();
            $this->oldItem->save();
        }

        return redirect("/month/$month->id/transactions/sort");
    }
    public function getItemPlanned() : Budge
    {
        return new Budge($this->item->planned, true);
    }

    public function getOldItemPlanned() : Budge
    {
        return new Budge($this->oldItem->planned, true);
    }

    public function getTransactionsSum() : Budge
    {
        return new Budge($this->item->transactions->sum('spent'), true);
    }

    public function getOldItemTransactionsSum() : Budge
    {
        return new Budge($this->oldItem->transactions->sum('spent'), true);
    }
}
