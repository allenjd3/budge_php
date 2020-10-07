<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Paycheck;

class PaycheckTest extends TestCase
{
    /**
     * @test
     */
    public function the_payday_is_changed_from_float_to_integer_accuarately() {
        $paycheck = new Paycheck;
        $paycheck->payday = 32.34;
        $this->assertEquals('3234', $paycheck->payday);
    }
}
