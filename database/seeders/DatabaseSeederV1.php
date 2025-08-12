<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarLocation;
use App\Models\CarModel;
use App\Models\Country;
use App\Models\Dicti;
use App\Models\Partner;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeederV1
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

        $dictiColor = Dicti::factory()->create([
            "full_name" => "Car color",
            "constant" => "COLOR"
        ]);

        $colors = ["White", "Black", "Green", "Yellow", "Red", "Blue"];

        foreach ($colors as $color) {
            Dicti::factory()->create([
                "full_name" => $color,
                "parent_id" => $dictiColor->id,
            ]);
        }

        $creatorCars = Dicti::factory()->create([
            "full_name" => "Creator cars",
            "constant" => "CREATOR_CARS"
        ]);
        $dictiCreatorCarModels = ["BMW", "Toyota", "Huyndai", "BYC", "Mercedes", "Ferrari", "Lamborgini", "Porshe"];

        foreach ($dictiCreatorCarModels as $creator) {
            Dicti::factory()->create([
                "full_name" => $creator,
                "parent_id" => $creatorCars->id,
            ]);
        }

        $dictiStamp = Dicti::factory()->create([
            "full_name" => "Stamp cars",
            "constant" => "STAMP_CARS"
        ]);

        $stamps = ["stamp1", "stamp2", "stamp3", "stamp4"];

        foreach ($stamps as $stamp) {
            Dicti::factory()->create([
                "full_name" => $stamp,
                "parent_id" => $dictiStamp->id
            ]);
        }

        $dictiBodyCar = Dicti::factory()->create([
            "full_name" => "Body car",
            "constant" => "BODY_CAR"
        ]);

        $carBodys = ["body1", "body2", "body3", "body4"];

        foreach ($carBodys as $carBody) {
            Dicti::factory()->create([
                "full_name" => $carBody,
                "parent_id" => $dictiBodyCar->id
            ]);
        }

        $dictiEngine = Dicti::factory()->create([
            "full_name" => "Engine",
            "constant" => "ENGINE"
        ]);

        $carEngines = ["engine1", "engine2", "engine3", "engine4"];

        foreach ($carEngines as $engine) {
            Dicti::factory()->create([
                "full_name" => $engine,
                "parent_id" => $dictiEngine->id
            ]);
        }

        $dictiTransmission = Dicti::factory()->create([
            "full_name" => "Transmission",
            "constant" => "TRANSMISSION"
        ]);

        $carTransmissions = ["transmission1", "transmission2", "etransmission", "transmission4"];

        foreach ($carTransmissions as $transmission) {
            Dicti::factory()->create([
                "full_name" => $transmission,
                "parent_id" => $dictiTransmission->id
            ]);
        }

        for ($i = 0; $i <= 10; $i++) {
            $carModel = CarModel::create([
                "creator_id" => Dicti::where("parent_id", Dicti::where("constant", "CREATOR_CARS")->first()->id)->get()->random()->id,
                "stamp_id" => Dicti::where("parent_id", Dicti::where("constant", "STAMP_CARS")->first()->id)->get()->random()->id,
                "body_id" => Dicti::where("parent_id", Dicti::where("constant", "BODY_CAR")->first()->id)->get()->random()->id,
                "engine_id" => Dicti::where("parent_id", Dicti::where("constant", "ENGINE")->first()->id)->get()->random()->id,
                "transmission_id" => Dicti::where("parent_id", Dicti::where("constant", "TRANSMISSION")->first()->id)->get()->random()->id,
                'engine_volume'      => fake()->numberBetween(1000, 5000),
                'power'              => fake()->numberBetween(70, 400),
                'seats'              => fake()->numberBetween(2, 8),
                'doors'              => fake()->numberBetween(2, 5),
                'fuel_tank_capacity' => fake()->numberBetween(30, 100),
                'weight'             => fake()->numberBetween(1000, 3000),
                'height'             => fake()->randomFloat(2, 1.2, 2.2),
                "active"             => fake()->boolean()
            ]);
            CarImage::create([
                "model_id" => $carModel->id,
                "filepath" => fake()->imageUrl()
            ]);
        };


        for ($i = 0; $i <= 10; $i++) {
            $car = Car::create([
                'model_id'             => CarModel::where("active",true)->get()->random()->id,
                'partner_id'           => Partner::inRandomOrder()->first()->id,
                'color_id'             => Dicti::where('parent_id', Dicti::where('constant', 'COLOR')->first()->id)->get()->random()->id,
                'vin'                  => strtoupper(fake()->bothify('??##############')),
                'license_plate'        => strtoupper(fake()->bothify('??###??')),
                'mileage'              => fake()->numberBetween(0, 300000),
                'last_inspection_date' => fake()->date(),
                'date_release'         => fake()->date(),
                'rating'               => fake()->numberBetween(1, 5),
                'active'               => fake()->boolean(),
            ]);

            if ($car->active) {
                CarLocation::create([
                    'car_id'   => $car->id,
                    'address'  => fake()->address(),
                    'latitude' => fake()->latitude(),
                    'longitude' => fake()->longitude(),
                ]);
            }
        }
    }
}
