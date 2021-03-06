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
        $team = $this->create_team_by_user($user);

        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSee('January');

        $this->assertDatabaseHas('months', [
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);

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
