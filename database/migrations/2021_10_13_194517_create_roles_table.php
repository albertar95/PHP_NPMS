<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->char('NidRole',38)->collation('utf8mb4_persian_ci');
            $table->string('Title',100)->collation('utf8mb4_persian_ci');
            $table->dateTime('CreateDate');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidRole','PK_Role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
