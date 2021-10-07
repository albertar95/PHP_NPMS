<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->char('NidReport',38)->collation('utf8mb4_persian_ci');
            $table->string('ReportName',50)->collation('utf8mb4_persian_ci');
            $table->integer('ContextId');
            $table->integer('FieldId');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidReport','PK_Reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
