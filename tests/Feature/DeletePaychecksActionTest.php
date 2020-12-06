<?php

namespace Tests\Feature;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePaychecksActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_delete_paychecks()
    {
        $user = User::factory()->create();

        $paycheck = Paycheck::factory()->create([
            'name'=>'First Name'
        ]);
        $paychecks = Paycheck::factory()->count(2)->create();
        $this->assertDatabaseHas('paychecks', [
            'name'=>'First Name'
        ]);

        $this->actingAs($user)->delete('paychecks/'.$paycheck->id);

        $this->assertDatabaseMissing('paychecks', [
            'name'=>'First Name'
        ]);


        
    }
    
}
