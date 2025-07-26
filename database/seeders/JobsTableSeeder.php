<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jobs')->delete();
        
        \DB::table('jobs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'queue' => 'default',
                'payload' => '{"uuid":"38c0abd1-3dee-4a42-9c60-02ec2ff9f08f","displayName":"App\\\\Jobs\\\\WarmProductCacheJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":300,"retryUntil":null,"data":{"commandName":"App\\\\Jobs\\\\WarmProductCacheJob","command":"O:28:\\"App\\\\Jobs\\\\WarmProductCacheJob\\":0:{}"},"createdAt":1752912610,"delay":null}',
                'attempts' => 0,
                'reserved_at' => NULL,
                'available_at' => 1752912610,
                'created_at' => 1752912610,
            ),
        ));
        
        
    }
}