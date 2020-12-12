<?php

namespace App\Actions;

use App\Models\Category;
use Lorisleiva\Actions\Action;

class DeleteCategoryAction extends Action
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
        $category = Category::find($this->category);
        //foreach($category->items as $item) {
        //    foreach($item->transactions as $transaction) {
        //        $transaction->delete();
        //    }
        //    $item->delete();
        //}
        $category->delete();

        return redirect()->back();
    }
}
