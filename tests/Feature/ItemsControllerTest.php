<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class ItemsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_item_can_be_created() {
        $item = new Item;
        $item->name = "My first Item";
        $item->planned = 23.32;
        $item->is_fund = 1;
        $item->user_id = 1;
        $item->category_id = 1;
        $item->month_id = 1;
        $item->save();

        $this->assertDatabaseHas('items', [
            'name' => 'My first Item',
            'planned'=> '2332',
            'is_fund'=> 1,
            'user_id' => 1,
            'category_id'=>1,
            'month_id'=>1
        ]);
    }
}
