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
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $month = Month::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(302);
        $this->assertDatabaseHas('months', [
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);

    }
}
