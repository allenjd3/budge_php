<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Transaction;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_transaction_can_be_created() {
        $transaction = new Transaction;
        $transaction->name = "My Transaction";
        $transaction->user_id = 1;
        $transaction->month_id = 1;
        $transaction->spent = 34.45;
        $transaction->spent_date = '2020-10-25';
        $transaction->save();

        $this->assertDatabaseHas('transactions', [
            'name'=>'My Transaction',
            'user_id'=>1,
            'month_id'=>1,
            'spent'=>3445,
            'spent_date'=>'2020-10-25'
        ]);
    }
}
