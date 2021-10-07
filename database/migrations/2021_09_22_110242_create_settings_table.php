<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->char('NidSetting',38)->collation('utf8mb4_persian_ci');
            $table->string('SettingKey',100)->collation('utf8mb4_persian_ci');
            $table->string('SettingValue',250)->collation('utf8mb4_persian_ci');
            $table->string('SettingTitle',100)->collation('utf8mb4_persian_ci')->nullable(true);
            $table->boolean('IsDeleted')->default(false);
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary(['SettingKey','SettingValue'],'PK_Settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
