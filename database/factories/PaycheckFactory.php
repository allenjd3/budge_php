<?php

namespace Database\Factories;

use App\Models\Paycheck;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaycheckFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paycheck::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word;
            'payday'=>$this->faker->randomNumber(7, true),
            'pay_date'=>$this->faker->date(),
            'month_id'=>Month::factory()
        ];
    }
}
