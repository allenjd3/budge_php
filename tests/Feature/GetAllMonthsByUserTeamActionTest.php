<?php

namespace Tests\Feature;

use App\Models\Month;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllMonthsByUserTeamActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_get_all_months()
    {
        $user = User::factory()->create();
        $this->create_team_by_user($user);

        $months = Month::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('months');

        $response->assertStatus(200);
        foreach($months as $month)
        {
            $response->assertSee($month->month);
        }
        
    }

    public function create_team_by_user($user) {
        $team = new Team;
        $team->name = 'My first team';
        $team->personal_team = true;
        $team->user_id = $user->id;

        $team->save();

        return $team;
    
    }
    
}
