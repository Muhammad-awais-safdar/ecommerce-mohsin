<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefundRequestsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('refund_requests')->delete();
        
        
        
    }
}