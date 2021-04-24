<?php

namespace App\Actions;

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
        $itemCategory = $month->categories()->first();
        
        $itemDefault = $itemCategory->items()->firstOrCreate([
            'name' => 'Transaction Importer',
            'month_id' => $month->id,
            'is_fund' => 0
            ]);

        (new TransactionImport(
            $month,
            $itemDefault
        ))->import($csv->file_path, 'local', Excel::CSV);

        
        $itemDefault->remaining = $this->getPlanned($itemDefault)
                                ->subBudge($this->getTransactionsFromItem($itemDefault))
                                ->getInteger();
        $itemDefault->save();

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
