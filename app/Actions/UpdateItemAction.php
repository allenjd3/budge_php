<?php

namespace App\Actions;

use App\Models\Item;
use Lorisleiva\Actions\Action;

class UpdateItemAction extends Action
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

        $item = Item::find($this->item);

        $calculatedRemaining = $item->planned - $item->remaining;

        $item->name = $this->name;
        $item->planned = $this->planned;
        $item->remaining = $this->planned - $calculatedRemaining/100;
        $item->is_fund = $this->is_fund;
        $item->month_id = $this->month_id;
        $item->category_id = $this->category_id;
        $item->save();

        return redirect()->back();
    }
}
