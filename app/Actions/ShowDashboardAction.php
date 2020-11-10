<?php

namespace App\Actions;

use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Auth;

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
        $paid = $month->paychecks->sum('payday');
    
        $itemSum = 0;
        foreach($month->categories as $cat) {
            $itemSum += $cat->items->sum('planned');
        }
        $planning = $month->monthly_planned - $itemSum;
        $tSum = App\Models\Transaction::where('month_id', '=', $month->id)->sum('spent');
        $left = $paid-$tSum;
    
        return Inertia\Inertia::render('Dashboard', compact(['month', 'paid', 'left', 'planning']));
            // Execute the action.
    }
}
