<?php

namespace App\Actions;

use App\Models\CsvImport;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Lorisleiva\Actions\Action;

class DeleteImportTransactionAction extends Action
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

        $csvimport = CsvImport::find($this->csvimport);

        if (Storage::delete($csvimport->file_path)) {
            $csvimport->delete();
        }

        return redirect()->back();
    }
}
