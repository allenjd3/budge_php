<?php

namespace Tests\Feature;

use App\Models\Paycheck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorePaychecksActionTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_store_paychecks()
    {

        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $paycheck = Paycheck::factory()->make([
            'name'=>'First Paycheck'
        ]);

        $this->actingAs($user)->post('/paychecks', $paycheck->toArray());

        $this->assertDatabaseHas('paychecks', [
            'name'=>'First Paycheck'
        ]);


        
    }
    
}
