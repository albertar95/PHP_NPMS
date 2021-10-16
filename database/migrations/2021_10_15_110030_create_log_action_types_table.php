<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_action_types', function (Blueprint $table) {
            $table->integer('NidAction');
            $table->string('Title',100)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidAction','PK_LogActionTypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_action_types');
    }
}
