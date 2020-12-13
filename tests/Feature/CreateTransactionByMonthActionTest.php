<?php

namespace Tests\Feature;

use App\Models\Month;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTransactionByMonthActionTest extends TestCase
{
    use RefreshDatabase;
    /**
    * @test
    */
    function a_user_can_view_a_page_that_helps_them_create_transaction()
    {
        $user = User::factory()->create();
        $this->create_team_by_user($user);
        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);
        
        $response = $this->actingAs($user)->get('/create-transaction/'. $month->id);
        $response->assertStatus(200);

        $response->assertSee('Transactions');
        

    }

    /**
     * @test
     */
    function a_user_can_see_previous_transactions_on_the_create_transactions_page()
    {
        $user = User::factory()->create();
        $this->create_team_by_user($user);


        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);

        $transaction = Transaction::factory()->create([
            'name'=>'first'
        ]);
        $transactions = Transaction::factory()->count(3)->create();

        $this->assertEquals(3, $transactions->count());

        $response = $this->actingAs($user)->get('/create-transaction/'.$month->id);
        $response->assertStatus(200);

        $response->assertSee('first');

    }
    public function create_team_by_user($user) {
        $team = new Team;
        $team->name = 'My first team';
        $team->personal_team = true;
        $team->user_id = $user->id;

        $team->save();

        return $team;
    
    }
    /**
     * @test
     */
    //function a_user_can_see_no_more_than_20_transactions_on_the_create_transactions_page() {
    //    $this->withoutExceptionHandling();
    //    $user = User::factory()->create();
    //    $this->create_team_by_user($user);

    //    $month = Month::factory()->create([
    //        'month'=>'January',
    //        'year'=>'2020',
    //        'team_id'=>1
    //    ]);

    //    $transaction1 = Transaction::factory()->create([
    //        'name'=>'first'
    //    ]);
    //    $transactions = Transaction::factory()->count(22)->create();

    //    $this->assertEquals(22, $transactions->count());
    //    $transaction2 = Transaction::factory()->create([
    //        'name'=>'last'
    //    ]);

    //    $response = $this->actingAs($user)->get('/create-transaction/'.$month->id);
    //    $response->assertStatus(200);

    //    $response->assertSee('first');
    //    $response->assertDontSee('last');
    //    
    //}
    
    
}
