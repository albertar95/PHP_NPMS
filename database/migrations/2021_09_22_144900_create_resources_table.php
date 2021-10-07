<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->char('NidResource',38)->collation('utf8mb4_persian_ci');
            $table->string('ResourceName',50)->collation('utf8mb4_persian_ci');
            $table->char('ParentId',38)->collation('utf8mb4_persian_ci');
            $table->integer('ClassLevel')->nullable(true);
            $table->integer('SortNumber');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidResource','PK_Resources');
            $table->foreign('ParentId','FK_ResourceResource')->references('NidResource')->on('Resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
