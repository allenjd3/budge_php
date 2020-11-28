<?php

namespace App\Actions;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;

class DeleteItemAction extends Action
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

        $item = Item::find($this->item);
        foreach($item->transactions as $transaction){
            $transaction->delete();
        }
        $item->delete();
        return redirect()->back();

    }
}
