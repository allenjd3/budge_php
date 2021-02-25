<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Lorisleiva\Actions\Action;

class ShowDashboardByMonthAction extends Action
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
        $month = Auth::user()->currentTeam->months()->with([ 'categories.items', 'paychecks' ])->find($this->m);
        $pay = $month->paychecks->sum('payday');
        $tSum = Transaction::where('month_id', '=', $month->id)->sum('spent');
        $itemSum = $month->items->sum('planned');

        $paid = BudgetMath::init()->setNumber($pay)->getString();
        $planning = BudgetMath::init()->removeValueFromTotal($month->monthly_planned, $itemSum)->getString();
        $left = BudgetMath::init()->removeValueFromTotal($pay, $tSum)->getString();
        $monthlyPlanned = BudgetMath::init()->setNumber($month->monthly_planned)->getString();

        return Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning', 'monthlyPlanned']));
    }
}
