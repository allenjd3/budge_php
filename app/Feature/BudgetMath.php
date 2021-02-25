<?php

namespace App\Feature;

class BudgetMath
{
    public $number;

    public $value;

    public static function init() : self
    {
       return new self;
    
    }

    public function setNumber($number) : self
    {
        $this->number = $number;
        return $this;

    
    }
    public function setString($str) : self
    {
        $this->value = $str;
        $this->number = $str * 100;
        return $this;
    }

    public function getString() : String
    {
        $number = ($this->number /100);
        return "$" . number_format((float)$number, 2, '.', '');
    

    } 

    public function getInteger() : int
    {
        return  $this->number;
    }

    public function arraySum($arry) : self
    {
        $total = 0;
        foreach($arry as $a) {
            $total += $a;
        }
        $this->number = $total;

        return $this;
    
    }



    public function removeValueFromTotal($total, $val) : self
    {
        $this->setNumber($total-$val);
        return $this;
    }
    

}
