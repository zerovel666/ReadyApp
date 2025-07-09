<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dicti>
 */
class DictiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "full_name" => "Справочник",
            "parent_id" => null,
            "char_value" => null,
            "num_value" => null,
            "json_value" => null,
            "constant" => null,
            "constant1" => null,
            "constant2" => null,
        ];
    }
}
