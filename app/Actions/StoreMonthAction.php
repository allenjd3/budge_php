<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Item;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

class StoreMonthAction extends Action
{
    public $month1;
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
        $this->month1 = Auth::user()->currentTeam->months()->firstOrNew([
        'month'=>$this->month,
        'year'=>$this->year
        ]);
        $this->month1->team_id = $this->user()->currentTeam->id;
        $this->month1->save();

        if ($this->copymonth === null) {
            return;
        }

        $month2 = Month::find($this->copymonth);

        if ($month2->categories()->exists()) {
            $this->copyPreviousMonthCategories($month2->categories);
        }
     

        return redirect()->route('dashboard-month', ['m' => $this->month1->id]);
    }

    public function copyPreviousMonthCategories($categories)
    {
        foreach ($categories as $category) {
            $c = new Category();
            $c->name = $category->name;
            $c->month_id = $this->month1->id;
            $c->save();
            if ($category->items()->exists()) {
                $this->copyPreviousMonthItems($category->items, $c);
            }
        }
    }

    public function copyPreviousMonthItems($items, $c)
    {
        foreach ($items as $item) {
            $i = new Item();
            $i->name = $item->name;
            $i->is_fund = $item->is_fund;
            $this->copyPlannedIfFund($item, $i);

            $i->category_id = $c->id;
            $i->month_id = $this->month1->id;
            $i->save();
        }
    }

    public function copyPlannedIfFund($item, $i)
    {
        if ($item->is_fund) {
            $i->fund_planned = $item->fund_planned;
            $i->planned = $item->fund_planned + $item->remaining;
            $i->remaining = $i->planned;
        } else {
            $i->planned = $item->planned;
            $i->remaining = $item->planned;
        }
    }
}
