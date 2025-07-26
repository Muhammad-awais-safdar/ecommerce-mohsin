<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('site_settings')->delete();
        
        \DB::table('site_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'robots_txt' => 'User-agent: *
Disallow: /admin/
Disallow: /login/
Disallow: /register/
Allow: /
',
                'favicon' => 'favicons/01JVT0C719FBWRKKFZN1VZYW6W.png',
                'created_at' => '2025-05-21 23:06:03',
                'updated_at' => '2025-05-21 23:06:03',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}