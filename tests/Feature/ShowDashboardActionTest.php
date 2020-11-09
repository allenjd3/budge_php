<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Month;
use App\Models\User;
use App\Models\Team;

class ShowDashboardActionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_user_can_show_the_dashboard()
    {
        $team = Team::factory()->create();
        $month = Month::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $this->assertDatabaseHas('months', [
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);

    }
}
