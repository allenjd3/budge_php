<?php

namespace App\Actions;

use App\Models\Category;
use Lorisleiva\Actions\Action;

class StoreCategoryAction extends Action
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
            'name'=>'required'
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle()
    {

        $category = new Category;
        $category->name = $this->name;
        $category->month_id = $this->month_id;
        $category->save();

        return redirect()->back();
    }
}
