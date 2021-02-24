<?php

namespace App\Actions;

use App\Feature\BudgetMath;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
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
        $tSum = Transaction::where('month_id', '=', $month->id)->sum('spent');

        $left = BudgetMath::init()->removeValueFromTotal($pay, $tSum);
        $paid = BudgetMath::init()->stringifyNumber($pay);
        $planning = BudgetMath::init()->removeValueFromTotal($month->monthly_planned, $itemSum);
        $monthlyPlanned = BudgetMath::init()->stringifyNumber($month->monthly_planned);
    
        return Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning', 'monthlyPlanned']));
            // Execute the action.
    }
}
