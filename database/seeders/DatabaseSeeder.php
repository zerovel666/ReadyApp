<?php

namespace Database\Seeders;

use App\Models\{Car, CarImage, CarLocation, CarModel, Country, Dicti, Partner, Role, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создание стран и партнёров
        $countries = Country::factory(3)->create();

        foreach ($countries as $country) {
            // Дочерняя страна
            Country::factory()->create([
                'name' => fake()->city(),
                'parent_countries_id' => $country->id,
            ]);

            // Партнёр
            Partner::factory()->create([
                'country_id' => $country->id,
            ]);
        }

        // Повторное добавление дочерних стран
        foreach ($countries as $country) {
            Country::factory()->create([
                'name' => fake()->city(),
                'parent_countries_id' => $country->id,
            ]);
        }

        // Тип авторизации
        $authType = Dicti::factory()->create(['full_name' => 'Тип авторизации']);

        $authMethods = [
            ['full_name' => 'Google авторизация', 'constant' => 'GOOGLE_AUTH'],
            ['full_name' => 'VK авторизация', 'constant' => 'VK_AUTH'],
            ['full_name' => 'Telegram авторизация', 'constant' => 'TELEGRAM_AUTH'],
            ['full_name' => 'Web авторизация', 'constant' => 'WEB_AUTH'],
        ];

        foreach ($authMethods as $method) {
            Dicti::factory()->create(array_merge($method, ['parent_id' => $authType->id]));
        }

        // Роли и пользователи
        $roles = [
            ['name' => 'Админ', 'slug' => 'admin'],
            ['name' => 'Агент', 'slug' => 'agent'],
            ['name' => 'Пользователь', 'slug' => 'standart'],
        ];

        foreach ($roles as $roleData) {
            $role = Role::create($roleData);
            $user = User::factory()->create();
            $user->roles()->attach($role->id);
        }

        // Справочники
        $this->seedDicti('COLOR', 'Car color', ['White', 'Black', 'Green', 'Yellow', 'Red', 'Blue']);
        $this->seedDicti('CREATOR_CARS', 'Creator cars', ['BMW', 'Toyota', 'Huyndai', 'BYC', 'Mercedes', 'Ferrari', 'Lamborgini', 'Porshe']);
        $this->seedDicti('STAMP_CARS', 'Stamp cars', ['stamp1', 'stamp2', 'stamp3', 'stamp4']);
        $this->seedDicti('BODY_CAR', 'Body car', ['body1', 'body2', 'body3', 'body4']);
        $this->seedDicti('ENGINE', 'Engine', ['engine1', 'engine2', 'engine3', 'engine4']);
        $this->seedDicti('TRANSMISSION', 'Transmission', ['transmission1', 'transmission2', 'etransmission', 'transmission4']);

        // Создание моделей авто и изображений
        for ($i = 0; $i <= 10; $i++) {
            $carModel = CarModel::create([
                'creator_id'      => $this->randomDictiChildId('CREATOR_CARS'),
                'stamp_id'        => $this->randomDictiChildId('STAMP_CARS'),
                'body_id'         => $this->randomDictiChildId('BODY_CAR'),
                'engine_id'       => $this->randomDictiChildId('ENGINE'),
                'transmission_id' => $this->randomDictiChildId('TRANSMISSION'),
                'engine_volume'   => fake()->numberBetween(1000, 5000),
                'power'           => fake()->numberBetween(70, 400),
                'seats'           => fake()->numberBetween(2, 8),
                'doors'           => fake()->numberBetween(2, 5),
                'fuel_tank_capacity' => fake()->numberBetween(30, 100),
                'weight'          => fake()->numberBetween(1000, 3000),
                'height'          => fake()->randomFloat(2, 1.2, 2.2),
            ]);

            CarImage::create([
                'model_id'   => $carModel->id,
                'image_path' => fake()->imageUrl(),
            ]);
        }

        // Создание авто и локаций
        for ($i = 0; $i <= 10; $i++) {
            $car = Car::create([
                'model_id'             => CarModel::inRandomOrder()->first()->id,
                'partner_id'           => Partner::inRandomOrder()->first()->id,
                'color_id'             => Dicti::where('parent_id', Dicti::where('constant', 'COLOR')->first()->id)->inRandomOrder()->first()->id,
                'vin'                  => strtoupper(fake()->bothify('??##############')),
                'license_plate'        => strtoupper(fake()->bothify('??###??')),
                'mileage'              => fake()->numberBetween(0, 300000),
                'last_inspection_date' => fake()->date(),
                'booked'               => fake()->boolean(),
                'date_release'         => fake()->date(),
                'rating'               => fake()->numberBetween(1, 5),
                'active'               => fake()->boolean(),
            ]);

            if ($car->active) {
                CarLocation::create([
                    'car_id'    => $car->id,
                    'address'   => fake()->address(),
                    'latitude'  => fake()->latitude(),
                    'longitude' => fake()->longitude(),
                ]);
            }
        }
    }

    // Утилита для генерации словаря и дочерних элементов
    private function seedDicti(string $constant, string $name, array $children): void
    {
        $parent = Dicti::factory()->create([
            'full_name' => $name,
            'constant'  => $constant,
        ]);

        foreach ($children as $childName) {
            Dicti::factory()->create([
                'full_name' => $childName,
                'parent_id' => $parent->id,
            ]);
        }
    }

    // Получение случайного дочернего Dicti по constant родителя
    private function randomDictiChildId(string $parentConstant): int
    {
        return Dicti::where('parent_id', Dicti::where('constant', $parentConstant)->first()->id)->inRandomOrder()->first()->id;
    }
}
