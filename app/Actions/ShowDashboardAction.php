<?php

namespace App\Actions;

use App\BudgeIt\Budge;
use App\Feature\BudgetMath;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShowDashboardAction extends Action
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
                             ->orderByDesc('id')
                             ->with([
                                 'categories.items',
                             ])->first();

        if ($this->month === null) {
            return redirect('/months');
        }

        $pay = $this->getPaychecksSum();

        $itemSum = $this->getPlannedSum();

        $transactions = $this->getTransactions();

        $fund_planned = $this->getFundPlannedSum();
 
        $transactions->addBudge($fund_planned);

        $paid = $pay->getString();

        $left = $pay->subBudge($transactions)->getString();

        $monthPlan = new Budge($this->month->monthly_planned, true);

        $monthlyPlanned = $monthPlan->getString();

        $planning = $monthPlan->subBudge($itemSum)->getString();
    
        return Inertia::render('Dashboard', [
            'month' => $this->month,
            'paid' => $paid,
            'left' => $left,
            'planning' => $planning,
            'monthlyPlanned' => $monthlyPlanned
        ]);
    }

    public function getTransactions() : Budge
    {
        $sum_spent = collect( 
            DB::select(
                'SELECT SUM(spent) AS sum_spent 
                FROM months 
                INNER JOIN transactions ON months.id = transactions.month_id 
                WHERE months.id = :month_id', [
                    "month_id" => $this->month->id
                ]
            ) 
        );

        return new Budge($sum_spent->first()->sum_spent, true);
    
    }

    public function getPlannedSum() : Budge
    {


        $planned = collect( 
            DB::select('SELECT SUM(planned) AS items_planned 
                        FROM months INNER JOIN items ON months.id = items.month_id 
                        WHERE months.id = :month_id', [
                            'month_id' => $this->month->id
                        ]
            ) 
        );

        return new Budge($planned->first()->items_planned, true);
    }

    public function getFundPlannedSum() : Budge
    {
        $fund_planned = collect( 
            DB::select('SELECT SUM(fund_planned) AS sum_fund_planned 
                        FROM months INNER JOIN items ON months.id = items.month_id 
                        WHERE months.id = :month_id
                        AND items.is_fund = true', ['month_id' => $this->month->id]
            ) 
        );

        return new Budge($fund_planned->first()->sum_fund_planned, true);
    }

    public function getPaychecksSum() : Budge
    {
        $paychecks = collect( 
            DB::select('SELECT SUM(payday) AS sum_payday 
                        FROM months INNER JOIN paychecks ON months.id = paychecks.month_id 
                        WHERE months.id = :month_id', [
                            'month_id' => $this->month->id
                        ]
            ) 
        );

        return new Budge($paychecks->first()->sum_payday, true);
    }
}
