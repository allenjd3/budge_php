<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteItemActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_delete_items()
    {
        $user = User::factory()->create();
        $item_delete = Item::factory()->create([
            'name'=>'First Name'
        ]);

        $items = Item::factory()->count(2)->create();
        $this->assertDatabaseHas('items', [
            'name'=>'First Name'
        ]);

        $response = $this->actingAs($user)->delete('/items/1');

        $this->assertDatabaseMissing('items', [
            'name'=>'First Name'
        ]);
    }
    
}
