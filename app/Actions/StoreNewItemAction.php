<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Item;
use Lorisleiva\Actions\Action;

class StoreNewItemAction extends Action
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
            'name' =>'required',
            'planned'=>'required|numeric',
            'category_id'=>'required'
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {
        $item = new Item;
        $item->name = $this->name;
        $item->planned = BudgetMath::init()->setString($this->planned)->getInteger();
        $item->remaining = BudgetMath::init()->removeValueFromTotal($item->planned, $item->transactions->sum('spent'))
                                             ->getInteger();
        $item->is_fund = $this->is_fund;
        if ($item->is_fund) {
            $item->fund_planned = BudgetMath::init()->setString($this->planned)->getInteger();
        }
        $item->month_id = $this->month_id;
        $item->category_id = $this->category_id;
        $item->save();

        return redirect()->back();
    }
}
