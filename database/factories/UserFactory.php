<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            "email" => $this->faker->email,
            "full_name" => $this->faker->name()." ".$this->faker->lastName(),
            "country_id" => Country::find(4)->id,
            "partner_id" => Partner::find(1)->id,
            "telegram_chat_id" => $this->faker->numberBetween(10000,20000),
            "uniq_id_people" => $this->faker->numberBetween(10000,20000),
            "phone" => $this->faker->phoneNumber,
        ];
    }
}
