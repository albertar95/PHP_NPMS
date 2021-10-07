<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->char('NidUnit',38)->collation('utf8mb4_persian_ci');
            $table->string('Title',100)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidUnit','PK_Units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
