<?php

namespace App\Feature;

class BudgetMath
{
    public static function init() : self
    {
       return new self;
    
    }

    public function stringifyNumber($num) : String
    {
        $number = ($num /100);
        return "$" . number_format((float)$number, 2, '.', '');
    
    } 

    public function getArraySum($arry) : String
    {
        $total = 0;
        foreach($arry as $a) {
            $total += $a;
        }

        return $this->stringifyNumber($total);
    
    }

    public function integerifyString($strg) : int
    {
        return  $strg * 100;
    }

    public function integerifyStringWithDollarSign($strg) : int
    {
        $val = explode('$', $strg);
        return $val[1] * 100;
    
    }

    public function removeValueFromTotal($total, $val) : String
    {
        return $this->stringifyNumber($total-$val);
    
    }

    

}
