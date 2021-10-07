<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->char('NidAlarm',38)->collation('utf8mb4_persian_ci');
            $table->char('NidMaster',38)->collation('utf8mb4_persian_ci');
            $table->string('AlarmSubject',50)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('AlarmStatus');
            $table->string('Description',8000)->collation('utf8mb4_persian_ci')->nullable(true);
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary(['NidMaster','AlarmSubject'],'PK_Alarms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alarms');
    }
}
