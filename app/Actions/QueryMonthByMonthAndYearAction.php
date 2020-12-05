<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

class QueryMonthByMonthAndYearAction extends Action
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
        $month = Auth::user()->currentTeam->months()->where('month','=',$this->m)->where('year','=',$this->year)->first();
        if( $month === null){
            return redirect('/months');
        }
        return redirect()->route('dashboard-month', ['m'=>$month->id]);
    }
}
