<?php

namespace App\Actions;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class StoreImportTransactionsAction extends Action
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
        return [
            'csvimport'=>'required|mimes:csv,txt'
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $csv_path = $request->file('csvimport')->store('temp');

        $request->user()->currentTeam->csvimports()->create([
            'file_path'=> $csv_path,
            'delete_by'=> Carbon::now()->addDays(1),
        ]);
        $csvimports = $request->user()->currentTeam->csvimports()->get();
        if ($csv_path) {
            return Inertia::render('ImportTransactions', [
                'message'=>'Successfully added new transactions',
                'month' => $this->month,
                'csvimports'=> $csvimports
            ]);
        } else {
            return ['message' => 'error'];
        }
    }
}
