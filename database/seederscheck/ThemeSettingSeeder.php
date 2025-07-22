<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThemeSetting;


class ThemeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'color_background' => '#ffffff',
            'color_text_primary' => '#2C2C2C',
            'color_text_secondary' => '#8C8C8C',
            'color_accent_primary' => '#C7A200',
            'color_accent_secondary' => '#FFD700',
            'color_border' => '#DDD6C5',
        ];

        foreach ($colors as $key => $value) {
            ThemeSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}