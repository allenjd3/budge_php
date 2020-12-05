<?php

namespace Tests\Feature;

use App\Models\Month;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QueryMonthByMonthAndYearActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_query_a_month_by_month_and_year()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->create_team_by_user($user);
        $month = Month::factory()->create([
            'month'=>'January',
            'year'=>'2020'
        ]);

        $response = $this->actingAs($user)->get('/month/'.$month->month.'/year/'.$month->year);

        $response->assertRedirect('dashboard/1');

        
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
