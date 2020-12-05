<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreCategoryActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_store_a_category()
    {
        $user = User::factory()->create();

        $category = Category::factory()->make([
            'name'=>'first category'
        ]);

        $this->actingAs($user)->post('categories', $category->toArray());

        $this->assertDatabaseHas('categories', [
            'name' =>'first category'
        ]);
        
    }
    
}
