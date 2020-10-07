<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoriesControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_category_can_be_created() {
        $category = new Category;
        $category->name = "My Famous Cat";
        $category->user_id = 1;
        $category->month_id = 1;
        $category->save();

        $this->assertDatabaseHas('categories', [
            'name'=>'My Famous Cat',
            'user_id'=> 1,
            'month_id'=>1
        ]);
    }
}
