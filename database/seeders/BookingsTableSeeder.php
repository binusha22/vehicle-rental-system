<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('bookings')->insert([
                'invoice_number' => $faker->unique()->numerify('INV####'),
                'vehicle_number' => $faker->regexify('[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}'),
                'vehicle_name' => $faker->word,
                'customer_id' => $faker->numberBetween(1, 100),
                'customer_name' => $faker->name,
                'cus_id' => $faker->numerify('ID####'),
                'cus_passport' => $faker->regexify('[A-Z0-9]{8}'),
                'mobile' => $faker->phoneNumber,
                'vehicle_pickup_location' => $faker->address,
                'reg_date' => $faker->dateTimeThisDecade,
                'select_employee' => $faker->name,
                'start_date' => $faker->dateTimeThisYear,
                'end_date' => $faker->dateTimeThisYear,
                'status' => "booked",
                's_mileage' => $faker->numberBetween(0, 100000),
                'e_mileage' => $faker->numberBetween(0, 100000),
                'trip_range' => $faker->numberBetween(0, 1000),
                'uploadImage_url' => $faker->imageUrl(),
                'fual' => $faker->randomFloat(2, 0, 1),
                'end_fual' => $faker->randomFloat(2, 0, 1),
                'advanced' => $faker->randomFloat(2, 0, 1000),
                'amount' => $faker->randomFloat(2, 0, 5000),
                'rest' => $faker->randomFloat(2, 0, 1000),
                'agreedmile' => $faker->numberBetween(0, 1000),
                'additinalMile' => $faker->numberBetween(0, 500),
                'flight_number' => $faker->numerify('FL####'),
                'arrival_date' => $faker->dateTimeThisYear,
                'landing_time' => $faker->time,
                'additonal_cost_km' => $faker->randomFloat(2, 0, 50),
            ]);
        }
    }
}
