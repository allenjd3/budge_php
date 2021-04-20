<?php

namespace App\Actions;

use Inertia\Inertia;
use App\Models\Month;
use App\BudgeIt\Budge;
use App\Models\CsvImport;
use Maatwebsite\Excel\Excel;
use Lorisleiva\Actions\Action;
use App\Imports\TransactionImport;

class ConfirmParseTransactionImport extends Action
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
        $csv = CsvImport::find($this->csvimport);
        $month = Month::find($this->month);
        $itemFirst = $month->items()->first();

        (new TransactionImport(
            $month,
            $itemFirst
        ))->import($csv->file_path, 'local', Excel::CSV);

        
        $itemFirst->remaining = $this->getPlanned($itemFirst)
                                ->subBudge($this->getTransactionsFromItem($itemFirst))
                                ->getInteger();
        $itemFirst->save();

        return redirect("/create-transaction/$month->id");
    }

    public function getPlanned($item) : Budge
    {
        return new Budge($item->planned, true);
    }

    public function getTransactionsFromItem($item) : Budge
    {
        return new Budge($item->transactions->sum('spent'), true);
    }
}
