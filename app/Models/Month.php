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

    public function items() {
        return $this->hasMany(Item::class);
    
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function paychecks() {
        return $this->hasMany(Paycheck::class);
    }

    public function setMonthlyPlannedAttribute($value) {

        $this->attributes['monthly_planned'] = $value * 100;
    }

}
