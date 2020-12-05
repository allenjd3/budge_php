<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateItemActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_update_an_item()
    {
        $user = User::factory()->create();
        
        $item = Item::factory()->count(3)->create();
        $item_updated = Item::factory()->make([
            'name'=>'My First'
        ]);
        $this->assertDatabaseMissing('items', [
            'name'=>'My First'
        ]);

        $response = $this->actingAs($user)->put('/items/1', $item_updated->toArray());

        $this->assertDatabaseHas('items', [
            'name'=>'My First'
        ]);

    }
    
}
