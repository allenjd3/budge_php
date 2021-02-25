<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Paycheck;
use Lorisleiva\Actions\Action;

class UpdatePaychecksAction extends Action
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
        $paycheck = Paycheck::find($this->paycheck);
        $paycheck->name = $this->name;
        $paycheck->payday = BudgetMath::init()->setString($this->payday)->getInteger();
        $paycheck->pay_date = $this->pay_date;
        $paycheck->month_id = $this->month_id;

        $paycheck->save();

        return redirect()->back();
    }
}
