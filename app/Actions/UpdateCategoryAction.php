<?php

namespace App\Actions;

use Lorisleiva\Actions\Action;

class UpdateCategoryAction extends Action
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
        $category->name = $this->category['name'];
        $category->save();

        return redirect()->back();
    }
}
