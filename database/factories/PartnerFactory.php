<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->company(),
            "detail_info" => $this->faker->text(250),
            "email" => $this->faker->companyEmail(),
            "phone" => $this->faker->phoneNumber(),
            "country_id" => Country::inRandomOrder("id"),
            "address" => $this->faker->address(),
            "logo_path" => $this->faker->filePath(),
        ];
    }
}
