<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Paycheck;

class PaychecksControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_paycheck_can_be_created() {
        $paycheck = new Paycheck;
        $paycheck->name = "My Name";
        $paycheck->payday = 32.44;
        $paycheck->pay_date = '2020-10-06';
        $paycheck->user_id = 1;
        $paycheck->month_id = 1;
        $paycheck->save();

        $this->assertDatabaseHas('paychecks', [
            'name'=>'My Name',
            'payday'=>3244,
            'pay_date'=> '2020-10-06',
            'user_id'=> 1,
            'month_id'=>1,
        ]);
    }
}
