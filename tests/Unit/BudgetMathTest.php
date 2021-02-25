<?php
namespace Tests\Unit;

use App\Feature\BudgetMath;
use PHPUnit\Framework\TestCase;

class BudgetMathTest extends TestCase
{
    /**
     * @test
     */
    public function when_given_a_integer_can_return_currency()
    {
        $this->assertEquals(BudgetMath::init()->setNumber(2300)->getString(), "$23.00");
    
    }

    /**
     * @test
     */
    public function when_given_array_of_integers_can_return_added_result()
    {
        $this->assertEquals(BudgetMath::init()->arraySum([2300, 2300, 200])->getString(), "$48.00");
    
    }

    /**
     * @test
     */
    public function when_given_a_string_it_can_return_an_integer()
    {
        $this->assertEquals(BudgetMath::init()->setString("23.00")->getInteger(), 2300);
    }


    /**
     * @test
     */
    public function when_given_two_numbers_can_subtract_them()
    {
        $this->assertEquals(BudgetMath::init()->removeValueFromTotal(4600, 2300)->getString(), "$23.00");

    
    }
}
