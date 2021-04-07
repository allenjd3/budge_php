<?php

namespace Tests\Unit\BudgeIt;

use App\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\BudgeIt\Budge;

class BudgeTest extends TestCase
{
    /**
     * @test
     */
    public function a_budge_can_be_initialized() {
        $budge = new Budge('2.30');
        $this->assertInstanceOf(Budge::class, $budge);
    
    }

    /**
     * @test
     */
    public function a_budge_can_return_an_integer() {
        $budge = new Budge('2.30');

        $this->assertEquals(230, $budge->getInteger());

        $budge2 = new Budge(330, true);

        $this->assertEquals(330, $budge2->getInteger());
    
    }

    /**
     * @test
     */
    public function non_numeric_input_throws_exception() {
        $this->expectException(InvalidArgumentException::class);
        $budge = new Budge("hello");
    
    }

    /**
     * @test
     */
    public function a_budge_can_return_a_string() {

        $budge = new Budge('2.30');
    
        $this->assertEquals('2.30', $budge->getString());
    
    }

    /**
     * @test
     */
    public function a_budge_can_subtract_another_budge() {
        $budge1 = new Budge('2.30');
        $budge2 = new Budge('0.01');

        $this->assertEquals(229, $budge1->subBudge($budge2)->getInteger());
    
    }

    /**
     * @test
     */
    public function a_budge_can_add_another_budge() {
        $budge1 = new Budge('2.30');
        $budge2 = new Budge('0.01');

        $this->assertEquals(231, $budge1->addBudge($budge2)->getInteger());

    
    }

}
