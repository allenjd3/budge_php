<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Month;

class MonthsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_month_can_be_created() {
        $month = new Month;
        $month->month = "January";
        $month->year = "2003";
        $month->user_id = 1;
        $month->save();
        $this->assertDatabaseHas('months', [
            'month'=>'January',
            'year'=>'2003',
            'user_id'=> 1
        ]);
    }
}
