<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Database\Eloquent\Factories\Factory;

class Sub_categoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sub_category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = Category::all()->pluck('id')->toArray();
        return [
            'name' => $this->faker->word,
            'category_id' => $this->faker->randomElement($categories)
        ];
    }
}
