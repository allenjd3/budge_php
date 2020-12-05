<?php

namespace Tests\Feature;

use App\Models\Month;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowDashboardByMonthActionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_user_can_show_a_dashboard_by_month() {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $team = $this->create_team_by_user($user);

        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020',
            'team_id'=>1
        ]);
        $month = Month::factory()->create([
            'month'=>'February',
            'year'=>'2020',
            'team_id'=>1
        ]);
        $response = $this->actingAs($user)->get('/dashboard/1');

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
