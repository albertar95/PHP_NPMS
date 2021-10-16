<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->char('NidLog',38)->collation('utf8mb4_persian_ci');
            $table->char('UserId',38)->collation('utf8mb4_persian_ci');
            $table->string('Username',50)->collation('utf8mb4_persian_ci');
            $table->string('LogDate',10)->collation('utf8mb4_persian_ci');
            $table->string('IP',20)->collation('utf8mb4_persian_ci');
            $table->string('LogTime',8)->collation('utf8mb4_persian_ci');
            $table->integer('ActionId');
            $table->string('Description',250)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('LogStatus');
            $table->tinyInteger('ImportanceLevel');
            $table->tinyInteger('ConfidentialLevel');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidLog','PK_Logs');
            $table->foreign('ActionId','FK_LogLogAction')->references('NidAction')->on('log_action_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
