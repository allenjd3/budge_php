<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use App\Models\Month;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->sentence(3),
            'planned'=>$this->faker->randomNumber(4, true),
            'remaining'=>$this->faker->randomNumber(3, true),
            'category_id'=> Category::factory(),
            'is_fund'=> false,
            'month_id'=> Month::factory()
        ];
    }
}
