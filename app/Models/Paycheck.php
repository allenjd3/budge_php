<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
    use HasFactory;

    public function setPaydayAttribute($value) {
        $this->attributes['payday'] = $value * 100;
    }

    public function getPaydayAttribute($value) {
        return number_format( ( $value / 100 ), 2 );
    }
}
