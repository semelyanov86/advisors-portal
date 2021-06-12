<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Advisor;
use App\ValueObjects\DescriptionValueObject;
use App\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AdvisorFactory extends Factory
{
    protected $model = Advisor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => DescriptionValueObject::fromNative($this->faker->text),
            'availability' => $this->faker->boolean,
            'price' => MoneyValueObject::fromFullNative($this->faker->randomNumber()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
