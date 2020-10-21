<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function setPlannedAttribute($value) {

        $this->attributes['planned'] = $value * 100;
    }

    public function setRemainingAttribute($value) {

        $this->attributes['remaining'] = $value * 100;
    }

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
