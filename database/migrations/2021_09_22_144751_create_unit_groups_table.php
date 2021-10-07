<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_groups', function (Blueprint $table) {
            $table->char('NidGroup',38)->collation('utf8mb4_persian_ci');
            $table->char('UnitId',38)->collation('utf8mb4_persian_ci');
            $table->string('Title',100)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidGroup','PK_UnitGroups');
            $table->foreign('UnitId','FK_UnitUnitGroup')->references('NidUnit')->on('Units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_groups');
    }
}
