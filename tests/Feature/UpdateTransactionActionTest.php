<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTransactionActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_update_a_transaction()
    {
        $user = User::factory()->create();
        $transactions = Transaction::factory()->count(2)->create();
        $trans_the_first = Transaction::factory()->make([
            'name'=>'This is Us'
        ]);

        $response = $this->actingAs($user)->put('/transactions/1', $trans_the_first->toArray());

        $this->assertDatabaseHas('transactions', [
            'name' => 'This is Us'
        ]);
        
    }
    
}
