<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function setSpentAttribute($value) {
        return $this->attributes['spent'] = $value * 100;
    }

    public function getSpentAttribute($value) {
        return number_format( ( $value / 100 ), 2 );
    }

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    
    }
}
