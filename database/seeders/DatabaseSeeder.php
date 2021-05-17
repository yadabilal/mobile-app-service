<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<20; $i++)
        {
            Device::create([
                "uid"=> $i,
                "app_id"=> $i,
                "operating_system"=> Device::OPERATING_TYPE_IOS,
                "language"=> "tr",
            ]);

            Subscription::create([
                "device_id"=> Device::all()->random()->id,
                'expire_date' => Carbon::create('2021', '05', '17')
            ]);
        }

    }
}
