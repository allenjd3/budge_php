<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
    use HasFactory;

    public function month() {
        return $this->belongsTo(Month::class);
    }
}
