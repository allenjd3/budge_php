<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTransactionActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_delete_a_transaction()
    {
        $user = User::factory()->create();
        $first_transaction = Transaction::factory()->create([
            'name'=>'My first Transaction'
        ]);
        $transactions = Transaction::factory()->count(2)->create();

        $this->assertDatabaseHas('transactions', [
            'name'=>'My first Transaction'
        ]);
        $response = $this->actingAs($user)->delete('/transactions/1');

        $this->assertDatabaseMissing('transactions', [
            'name'=>'My first Transaction'
        ]);
    }
    
}
