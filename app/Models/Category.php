<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function items() {
        return $this->hasMany(Item::class);
    }
}
