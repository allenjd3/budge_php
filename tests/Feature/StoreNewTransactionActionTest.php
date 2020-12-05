<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreNewTransactionActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_store_a_new_transaction()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
       
        $item = Item::factory()->create();

        $transaction = Transaction::factory()->make([
            'name'=>'My First Transaction'
        ]);

        $response = $this->actingAs($user)->post('/transactions', $transaction->toArray());

        $response->assertStatus(302);

        $this->assertDatabaseHas('transactions', [
            'name'=>'My First Transaction'
        ]);

        
    }
    
}
