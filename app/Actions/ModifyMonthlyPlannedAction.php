<?php

namespace App\Actions;

use App\Models\Month;
use Lorisleiva\Actions\Action;

class ModifyMonthlyPlannedAction extends Action
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
        $month = Month::find($this->month_id);
        $month->monthly_planned = $this->monthly_planned;
        $month->save();

        return redirect()->back();
    }
}
