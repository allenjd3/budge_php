<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function setPlannedAttribute($value) {

        return $this->attributes['planned'] = $value * 100;
    }
    public function getPlannedAttribute($value) {
        return number_format( ( $value / 100 ), 2 );
    }

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
