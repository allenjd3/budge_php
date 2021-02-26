<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use App\Models\Item;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShowDashboardAction extends Action
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
        $month = Auth::user()->currentTeam->months()->orderByDesc('id')->with([ 'categories.items', 'paychecks' ])->first();
        if( $month === null){
            return redirect('/months');
        }
        $pay = $month->paychecks->sum('payday');
        $itemSum = $month->items->sum('planned');
        $transactions = Item::where('month_id', '=', $month->id)->where('is_fund', false)->with('transactions')->get()->pluck('transactions')->flatten();
        $fund_planned = Item::where('month_id', '=', $month->id)->where('is_fund', true)->sum('fund_planned');
 
        $tSum = $transactions->sum('spent') + $fund_planned;

        $left = BudgetMath::init()->removeValueFromTotal($pay, $tSum)->getString();
        $paid = BudgetMath::init()->setNumber($pay)->getString();
        $planning = BudgetMath::init()->removeValueFromTotal($month->monthly_planned, $itemSum)->getString();
        $monthlyPlanned = BudgetMath::init()->setNumber($month->monthly_planned)->getString();
    
        return Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning', 'monthlyPlanned']));
            // Execute the action.
    }
}
