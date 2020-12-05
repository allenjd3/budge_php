<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreNewItemActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_store_a_new_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->make([
            'name'=>'First Item'
        ]);

        $response = $this->actingAs($user)->post('/items', $item->toArray());

        $this->assertDatabaseHas('items', [
            'name' => 'First Item'
        ]);
        
    }
    
}
