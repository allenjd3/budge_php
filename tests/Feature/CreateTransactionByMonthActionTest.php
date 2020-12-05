<?php

namespace Tests\Feature;

use App\Models\Month;
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
        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);
        
        $response = $this->actingAs($user)->get('/create-transaction/'. $month->id);

        $response->assertSee('Transactions');
        

    }

    /**
    * @test
    */
    function a_user_can_see_previous_transactions_on_the_create_transactions_page()
    {
        $user = User::factory()->create();


        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);

        $transactions = Transaction::factory()->count(3)->create();

        $this->assertEquals(3, $transactions->count());

        $response = $this->actingAs($user)->get('/create-transaction/'.$month->id);

        foreach($transactions as $transaction)
        {
            $response->assertSee($transaction->name);
        
        }

    }
    
    
}
