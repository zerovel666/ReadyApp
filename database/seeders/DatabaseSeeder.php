<?php

namespace Database\Seeders;

use App\Models\{AgentInfo, Car, CarImage, CarLocation, CarModel, Country, Dicti, Partner, Role, User};
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
                'active'          => fake()->boolean()
            ]);

            CarImage::create([
                'model_id'   => $carModel->id,
                'image_path' => fake()->imageUrl(),
            ]);
        }

        $this->seedDicti('STATUS_CAR', 'Status cars', ["serviced", "booked", "free"]);
        // Создание авто и локаций
        for ($i = 0; $i <= 10; $i++) {
            $car = Car::create([
                'model_id'             => CarModel::where("active", true)->get()->random()->id,
                'partner_id'           => Partner::inRandomOrder()->first()->id,
                'color_id'             => Dicti::where('parent_id', Dicti::where('constant', 'COLOR')->first()->id)->inRandomOrder()->first()->id,
                'vin'                  => strtoupper(fake()->bothify('??##############')),
                'license_plate'        => strtoupper(fake()->bothify('??###??')),
                'mileage'              => fake()->numberBetween(0, 300000),
                'last_inspection_date' => fake()->date(),
                'date_release'         => fake()->date(),
                'rating'               => fake()->numberBetween(1, 5),
                'status'               => $this->randomDictiChildId("STATUS_CAR"),
            ]);
            
            CarLocation::create([
                'car_id'    => $car->id,
                'address'   => fake()->address(),
                'latitude'  => fake()->latitude(),
                'longitude' => fake()->longitude(),
            ]);
        }

        // AGENT
        $this->seedDicti("AGENT_STATUS", "Agent statuses", ["Not in place", "Active", "Pickup", "Delivers", "Waiting", "Machine maintenance"]);
        $this->seedDicti("SCHEDULE_WORK", "Schedule work", []);
        $schedule_work = Dicti::whereConstant("SCHEDULE_WORK")->first();
        $schedule = [
            "2/2",
            "5/2",
            "6/1"
        ];
        foreach ($schedule as $item) {
            Dicti::factory()->create([
                'full_name' => $item,
                'parent_id' => $schedule_work->id,
                'char_value' => $item
            ]);
        }

        $userAgent = User::whereHas('roles', function ($query) {
            $query->where('slug', 'agent');
        })->first();

        AgentInfo::create([
            "user_id" => $userAgent->id,
            "status_id" => $this->randomDictiChildId("AGENT_STATUS"),
            "schedule_work_id" => $this->randomDictiChildId("SCHEDULE_WORK"),
            "count_сompleted_tasks" => 0,
            "rating" => fake()->numberBetween(1, 4),
        ]);

        $this->seedAgentCheckList();
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

    private function seedAgentCheckList()
    {
        $this->seedDicti("AGENT_CHECK_LISTS", "Check lists", []);
        $checkListnum1 = [
            [
                "full_name" => "Check fuel level",
                "order_no" => 1
            ],
            [
                "full_name" => "Inspect the body for any damage",
                "order_no" => 2
            ],
            [
                "full_name" => "Check tire condition and pressure",
                "order_no" => 3
            ],
            [
                "full_name" => "Check interior cleanliness",
                "order_no" => 4
            ],
            [
                "full_name" => "Ensure keys and documents are present",
                "order_no" => 5
            ],
            [
                "full_name" => "Test headlights, brake lights, and turn signals",
                "order_no" => 6
            ],
            [
                "full_name" => "Check oil and fluid levels",
                "order_no" => 7
            ],
            [
                "full_name" => "Record mileage",
                "order_no" => 8
            ],
            [
                "full_name" => "Inspect windows and mirrors for damage",
                "order_no" => 9
            ],
            [
                "full_name" => "Verify all rented accessories are returned (e.g., charger, child seat)",
                "order_no" => 10
            ],
        ];

        $checkListnum2 = [
            [
                "full_name" => "Check and record fuel level",
                "order_no" => 1
            ],
            [
                "full_name" => "Inspect the car body for scratches, dents, or paint damage",
                "order_no" => 2
            ],
            [
                "full_name" => "Check front and rear bumpers for any cracks or dislocation",
                "order_no" => 3
            ],
            [
                "full_name" => "Inspect all four tires for wear, damage, and pressure levels",
                "order_no" => 4
            ],
            [
                "full_name" => "Check condition of rims and note any scratches or bends",
                "order_no" => 5
            ],
            [
                "full_name" => "Inspect undercarriage for leaks or unusual damage",
                "order_no" => 6
            ],
            [
                "full_name" => "Verify windshield and all windows are intact and clean",
                "order_no" => 7
            ],
            [
                "full_name" => "Check side and rear-view mirrors for cracks or looseness",
                "order_no" => 8
            ],
            [
                "full_name" => "Inspect wipers for functionality and rubber condition",
                "order_no" => 9
            ],
            [
                "full_name" => "Ensure headlights, brake lights, reverse lights, and indicators work properly",
                "order_no" => 10
            ],
            [
                "full_name" => "Check horn functionality",
                "order_no" => 11
            ],
            [
                "full_name" => "Check dashboard for warning lights (engine, oil, brakes, etc.)",
                "order_no" => 12
            ],
            [
                "full_name" => "Ensure car starts and idles smoothly",
                "order_no" => 13
            ],
            [
                "full_name" => "Test brake response and pedal resistance",
                "order_no" => 14
            ],
            [
                "full_name" => "Check steering alignment and ease of turning",
                "order_no" => 15
            ],
            [
                "full_name" => "Inspect interior for stains, tears, or odors",
                "order_no" => 16
            ],
            [
                "full_name" => "Ensure air conditioning and heating are working",
                "order_no" => 17
            ],
            [
                "full_name" => "Verify availability of vehicle registration and insurance documents",
                "order_no" => 18
            ],
            [
                "full_name" => "Check presence and condition of key accessories (e.g., spare tire, jack, tools)",
                "order_no" => 19
            ],
            [
                "full_name" => "Take photos of the vehicle from all angles as proof of return condition",
                "order_no" => 20
            ],
        ];

        $baseCheck = Dicti::create([
            "parent_id" => Dicti::whereConstant("AGENT_CHECK_LISTS")->first()->id,
            "full_name" => "Base check"
        ]);

        foreach ($checkListnum1 as $item) {
            Dicti::create([
                "full_name" => $item['full_name'],
                "order_no" => $item['order_no'],
                "parent_id" => $baseCheck->id
            ]);
        }

        $concretCheck = Dicti::create([
            "parent_id" => Dicti::whereConstant("AGENT_CHECK_LISTS")->first()->id,
            "full_name" => "Detailed check list"
        ]);

        foreach ($checkListnum2 as $item) {
            Dicti::create([
                "full_name" => $item['full_name'],
                "order_no" => $item['order_no'],
                "parent_id" => $concretCheck->id
            ]);
        }
    }
}
