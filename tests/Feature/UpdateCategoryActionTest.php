<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_update_a_category()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $categories = Category::factory()->count(2)->create();
        $category_update = Category::factory()->make([
            'name'=>'Updated Category'
        ]);
        $this->assertDatabaseMissing('categories', [
            'name'=>'Updated Category'
        ]);

        
        $response = $this->actingAs($user)->put('categories/1', $category_update->toArray());

        $response->assertStatus(302);

        $this->assertDatabaseHas('categories', [
            'name'=>'Updated Category'
        ]);
    }
    
}
