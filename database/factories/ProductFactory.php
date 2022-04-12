<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sub_category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subcategories = Sub_category::all()->pluck('id')->toArray();
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'sub_category_id' => $this->faker->randomElement($subcategories),
            'price' => $this->faker->randomFloat(),
            'photo' => $this->faker->word
        ];
    }
}
