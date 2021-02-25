<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }


    
}
