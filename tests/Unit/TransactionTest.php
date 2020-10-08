<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Transaction;

class TransactionTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_change_float_to_cents_before_saving() {
        $transaction = new Transaction;
        $transaction->spent = 34.45;
        $this->assertEquals(3445, $transaction->spent);
    }
}
