<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Item;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function a_planned_amount_is_mutated_to_integer() {
        $item = new Item;
        $item->planned = 34.44;
        $this->assertEquals(3444, $item->planned);
    }
}
