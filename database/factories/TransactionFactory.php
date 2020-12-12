<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Month;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->sentence(3),
            'item_id'=> Item::factory(),
            'month_id'=> Month::factory(),
            'spent'=>$this->faker->randomNumber(3,true),
            'spent_date'=>$this->faker->date()
        ];
    }
}
