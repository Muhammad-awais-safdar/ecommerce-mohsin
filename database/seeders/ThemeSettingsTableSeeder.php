<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ThemeSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('theme_settings')->delete();
        
        \DB::table('theme_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'color_background',
                'value' => '#ffffff',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'color_text_primary',
                'value' => '#2C2C2C',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'color_text_secondary',
                'value' => '#8C8C8C',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'color_accent_primary',
                'value' => '#C7A200',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'color_accent_secondary',
                'value' => '#FFD700',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'color_border',
                'value' => '#DDD6C5',
                'created_at' => '2025-05-13 15:56:08',
                'updated_at' => '2025-05-13 15:56:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}