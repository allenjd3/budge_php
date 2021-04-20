<?php

namespace App\BudgeIt;

use App\Exceptions\InvalidArgumentException;

class Budge
{
    private $value;

    public function __construct($input, $isInt = false)
    {
        if (!is_numeric($input)) {
            if (is_null($input)) {
                $this->value = 0;
            } else {
                throw new InvalidArgumentException;
            }
        }
        if ($isInt) {
            $this->value = $input;
            return;
        }

        $this->value = (int) bcmul($input, 100);
    }

    public function getInteger() : int
    {
        return $this->value;
    }

    public function getString() : String
    {
        $formattedNumber = $this->value / 100;

        return number_format($formattedNumber, 2);
    }

    public function subBudge(Budge $value) : self
    {
        $this->value = bcsub($this->value, $value->getInteger());

        return $this;
    }

    public function addBudge(Budge $value) : self
    {
        $this->value = bcadd($this->value, $value->getInteger());

        return $this;
    }
}
