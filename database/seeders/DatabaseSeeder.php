<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Country;
use App\Models\Dicti;
use App\Models\Partner;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $countries = Country::factory(3)->create();

        foreach ($countries as $country) {
            Country::factory(1)->create([
                'name' => fake()->city(),
                'parent_countries_id' => $country->id,
            ]);

            Partner::factory(1)->create([
                "country_id" => $country->id
            ]);
        }
        foreach ($countries as $country) {
            Country::factory(1)->create([
                'name' => fake()->city(),
                'parent_countries_id' => $country->id,
            ]);
        }

        $item = Dicti::factory()->create([
            "full_name" => "Тип авторизации"
        ]);

        $bodtDicti = [
            [
                "parent_id" => $item->id,
                "full_name" => "Google авторизация",
                "constant" => "GOOGLE_AUTH"
            ],
            [
                "parent_id" => $item->id,
                "full_name" => "VK авторизация",
                "constant" => "VK_AUTH"
            ],
            [
                "parent_id" => $item->id,
                "full_name" => "Telegram авторизация",
                "constant" => "TELEGRAM_AUTH"
            ],
            [
                "parent_id" => $item->id,
                "full_name" => "Web авторизация",
                "constant" => "WEB_AUTH"
            ]
        ];


        foreach ($bodtDicti as $itemD) {
            Dicti::factory()->create($itemD);
        }

        $roles = [
            [
                "name" => "Админ",
                "slug" => "admin"
            ],
            [
                "name" => "Агент",
                "slug" => "agent"
            ],
            [
                "name" => "Пользователь",
                "slug" => "standart"
            ],
        ];


        foreach ($roles as $role) {
            $roleCreating = Role::create($role);
            $user = User::factory()->create();
            $user->roles()->attach($roleCreating->id);
        }

    }
}
