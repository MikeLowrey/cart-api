<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'description' => $this->faker->text(180),
            'price' => ($this->faker->numberBetween(50, 500) * 100),
        ];
    }
}
