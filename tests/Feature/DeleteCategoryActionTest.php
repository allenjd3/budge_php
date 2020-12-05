<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_delete_a_category()
    {
        $user = User::factory()->create();

        $category_delete = Category::factory()->create([
            'name' =>'My Category'
        ]);
        $categories = Category::factory()->count(2)->create();
        $this->assertDatabaseHas('categories', [
            'name' =>'My Category'
        ]);

        $response = $this->actingAs($user)->delete('categories/1');

        $this->assertDatabaseMissing('categories', [
            'name' =>'My Category'
        ]);

    }
    
}
