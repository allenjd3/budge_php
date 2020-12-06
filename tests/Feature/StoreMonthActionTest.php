<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\Month;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreMonthActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_store_a_new_month()
    {
        $user = User::factory()->create();
        $this->create_team_by_user($user);

        $month = Month::factory()->make([
            'month'=>'January',
            'year'=>'2020',
        ]);

        $this->actingAs($user)->post('months', $month->toArray());

        $this->assertDatabaseHas('months', [
            'month'=>'January',
            'year'=>'2020'
        ]);

        
    }

    /**
    * 
    function a_user_can_copy_a_months_categories_and_transactions()
    {
        $user = User::factory()->create();
        $this->create_team_by_user($user);

        $month1 = Month::factory()->create();
        $categories = Category::factory()->count(3)->create([
            'month_id'=>$month1->id
        ]);
        $items = Item::factory()->count(3)->create([
            'month_id'=>$month1->id
        ]);
        $transactions = Transaction::factory()->count(3)->create([
            'month_id'=>$month1->id
        ]);

        $month2 = Month::factory()->make();

        $mymontharray = $month2->toArray();

        $mymontharray['copymonth'] = $month1->id;

        $response = $this->actingAs($user)->post('months', $mymontharray);

        $response->assertStatus(302);

        dd(Month::all());
        $this->assertDatabaseHas('transactions', [
            'name'=>$transactions[0]->name,
            'month_id'=> 2
        ]);
    }
    */
    

    public function create_team_by_user($user) {
        $team = new Team;
        $team->name = 'My first team';
        $team->personal_team = true;
        $team->user_id = $user->id;

        $team->save();

        return $team;
    
    }
    
}
