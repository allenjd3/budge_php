<?php

namespace App\Imports;

use App\BudgeIt\Budge;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionImport implements ToModel, WithHeadingRow
{
    use Importable;

    private $month;
    private $item;

    public function __construct($month, $item)
    {
        $this->month = $month;
        $this->item = $item;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Transaction([
            'name' => $row['name'],
            'spent' => ( new Budge($row['spent']) )->getInteger(),
            'spent_date' => $row['date'],
            'month_id' => $this->month->id,
            'item_id' => $this->item->id
        ]);
    }
}
