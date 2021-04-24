<?php

namespace App\Actions;

use App\BudgeIt\Budge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Lorisleiva\Actions\Action;

class ShowDashboardByMonthAction extends Action
{
    private $month;

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
        $this->month = Auth::user()->currentTeam
                             ->months()
                             ->with([
                                 'categories.items',
                                 'paychecks'
                             ])->find($this->m);

        $pay = $this->getPaychecksSum();

        $transactions = $this->getTransactionsSum();

        $fund_planned = $this->getFundPlannedSum();
 
        $tSum = $transactions->addBudge($fund_planned);
 
        $itemSum = $this->getItemPlannedSum();

        $monthlyPlanned = $this->getMonthlyPlanned();

        $paid = $pay->getString();

        $planning = $monthlyPlanned->subBudge($itemSum)->getString();

        $left = $pay->subBudge($tSum)->getString();

        return Inertia::render('Dashboard', [
            'month' => $this->month,
            'paid' => $paid,
            'left' => $left,
            'planning' => $planning,
            'monthlyPlanned' => $this->getMonthlyPlanned()->getString()
        ]);
    }

    public function getPaychecksSum() : Budge
    {
        $payday = collect(DB::select('SELECT SUM(payday) as payday_sum FROM paychecks WHERE month_id = :month_id', [
            "month_id"=> $this->month->id
        ]));

        return new Budge($payday->first()->payday_sum, true);
    }

    public function getTransactionsSum() : Budge
    {
        
        $transactions = collect(DB::select('SELECT SUM(spent) spent_sum FROM items 
                                            LEFT JOIN transactions ON items.id = transactions.item_id 
                                            WHERE items.month_id = :month_id AND items.is_fund IS FALSE', [
                                                "month_id" => $this->month->id
                                            ]));

        return new Budge($transactions->first()->spent_sum, true);
    }

    public function getFundPlannedSum() : Budge
    {
        
        $fund_planned = collect(DB::select('SELECT SUM(fund_planned) fund_planned_sum FROM items 
                                            WHERE items.month_id = :month_id 
                                            AND items.is_fund IS true', [
                                                'month_id' => $this->month->id
                                            ]));

        return new Budge($fund_planned->first()->fund_planned_sum, true);
    }

    public function getItemPlannedSum() : Budge
    {
    
        $planned = collect(DB::select('SELECT SUM(planned) AS planned_sum FROM months 
                                       LEFT JOIN items ON months.id = items.month_id 
                                       WHERE months.id = :month_id', [
                                           'month_id' => $this->month->id
                                       ]));
        
        return new Budge($planned->first()->planned_sum, true);
    }

    public function getMonthlyPlanned() : Budge
    {
        $monthlyPlanned = collect(DB::select('SELECT monthly_planned FROM months  
                                              WHERE months.id = :month_id', [
                                                  'month_id' => $this->month->id
                                              ]));

        return new Budge($monthlyPlanned->first()->monthly_planned, true);
    }
}
