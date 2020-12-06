<?php

namespace Tests\Feature;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePaychecksActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_update_paychecks_action_test()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $paycheck = Paycheck::factory()->create();

        $pay2 = Paycheck::factory()->make([
            'name'=>'Updated Name'
        ]);

        $this->actingAs($user)->put('paychecks/' . $paycheck->id, $pay2->toArray());

        $this->assertDatabaseHas('paychecks', [
            'name'=>'Updated Name'
        ]);
        
    }
    
}
