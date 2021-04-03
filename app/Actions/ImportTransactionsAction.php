<?php

namespace App\Actions;

use App\Models\Month;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Lorisleiva\Actions\Action;

class ImportTransactionsAction extends Action
{
    public $month;

    public function __construct(Request $request)
    {
        $this->month = Month::find($request->route()->parameter('month'));
    }
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return $request->user()->currentteam
                             ->months()
                             ->where('id', $this->month->id)
                             ->get();
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

        return Inertia::render('ImportTransactions', [
            'month' => $this->month
        ]);
    }
}
