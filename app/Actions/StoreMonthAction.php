<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Item;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Action;

class StoreMonthAction extends Action
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
    $month = Auth::user()->currentTeam->months()->firstOrNew([
        'month'=>$this->month,
        'year'=>$this->year
    ]);
    $month->team_id = $this->user()->currentTeam->id;
    $month->save();

    if($this->copymonth !== null) {
        $month2 = Month::find($this->copymonth);

        if($month2->categories()->exists()) {
            foreach($month2->categories as $category)
            {
                $c = new Category();
                $c->name = $category->name;
                $c->month_id = $month->id;
                $c->save();
                if($category->items()->exists()) {
                    foreach($category->items as $item)
                    {
                        $i = new Item();
                        $i->name = $item->name;
                        $i->planned = ( $item->planned )/100;
                        
                        $i->is_fund = $item->is_fund;
                        if($item->is_fund) {
                            $i->remaining = ( $item->remaining + $i->planned )/100;
                        }
                        else {
                            $i->remaining = ( $item->planned )/100;
                        }
                        $i->category_id = $c->id;
                        $i->month_id = $month->id;
                        $i->save();
                    }
                }

            }

        } 
    }
     

    return redirect()->route('dashboard-month', ['m'=>$month->id]);
    }
}
