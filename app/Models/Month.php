<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $fillable = ['month','year'];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
    public function setMonthlyPlannedAttribute($value) {

        return $this->attributes['monthly_planned'] = $value * 100;
    }

    public function getMonthlyPlannedAttribute($value) {
        return number_format( ( $value / 100 ), 2 );
    }
}
