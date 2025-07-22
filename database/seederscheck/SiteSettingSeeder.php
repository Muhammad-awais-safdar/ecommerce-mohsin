<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    SiteSetting::firstOrCreate(['id' => 1], [
        'robots_txt' => 'User-agent: *' . PHP_EOL . 'Disallow:',
    ]);
}
}