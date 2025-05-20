<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToMultipleTables extends Migration
{
    /**
     * List of tables to add soft deletes.
     *
     * @var array
     */
    protected $tables = [
        'activity_log',
        'contacts',
        'ebay_verifieds',
        'login_activities',
        'offers',
        'orders',
        'order_items',
        'pages',
        'password_reset_tokens',
        'products',
        'refund_requests',
        'reviews',
        'seos',
        'sessions',
        'site_settings',
        'theme_settings',
        'users',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }
}
