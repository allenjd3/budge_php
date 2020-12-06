<?php

namespace Tests\Feature;

use App\Models\Month;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModifyMonthlyPlannedActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_modify_the_monthly_planned_amount()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $month = Month::factory()->create();
        $month->refresh();

        $response = $this->actingAs($user)->post('/modify-planned', ['month_id'=>$month->id, 'monthly_planned' => 2350]);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('months', [
            'monthly_planned'=>235000
        ]);

        
    }
    
}
