<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackupLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->char('NidLog',38)->collation('utf8mb4_persian_ci');
            $table->dateTime('CreateDate');
            $table->integer('Duration');
            $table->text('Path')->collation('utf8mb4_persian_ci');
            $table->string('Size',25)->collation('utf8mb4_persian_ci');
            $table->tinyInteger('BackupStatus');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidLog','PK_Logs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backup_logs');
    }
}
