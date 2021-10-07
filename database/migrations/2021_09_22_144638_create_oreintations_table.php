<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOreintationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oreintations', function (Blueprint $table) {
            $table->char('NidOreintation',38)->collation('utf8mb4_persian_ci');
            $table->char('MajorId',38)->collation('utf8mb4_persian_ci');
            $table->string('Title',100)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidOreintation','PK_Oreintation');
            $table->foreign('MajorId','FK_MajorOreintation')->references('NidMajor')->on('Majors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oreintations');
    }
}
