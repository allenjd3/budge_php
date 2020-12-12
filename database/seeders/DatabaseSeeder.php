<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\Month;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $team = $this->create_team_by_user($user);
        $month = Month::factory()->hasCategories(20)->create();

        $categories = Category::all();

        foreach($categories as $category){
            Item::factory()->count(10)->state([
                'category_id'=>$category->id,
                'month_id'=>$month->id
            ])->create();
        }

        $items = Item::all();

        foreach($items as $item){
            Transaction::factory()->count(10)->state([
                'item_id'=>$item->id,
                'month_id'=>$month->id
            ])->create();
        }
        
    }
    public function create_team_by_user($user) {
        $team = new Team;
        $team->name = 'My first team';
        $team->personal_team = true;
        $team->user_id = $user->id;

        $team->save();

        return $team;
    
    }
}
