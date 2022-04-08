<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_files', function (Blueprint $table) {
            $table->char('NidFile',38)->collation('utf8mb4_persian_ci');
            $table->char('NidMaster',38)->nullable()->collation('utf8mb4_persian_ci');
            $table->integer('MasterType');
            $table->text('FilePath')->collation('utf8mb4_persian_ci');
            $table->string('FileName',8000)->collation('utf8mb4_persian_ci');
            $table->string('FileExtension',25)->collation('utf8mb4_persian_ci');
            $table->boolean('IsDeleted');
            $table->dateTime('CreateDate');
            $table->dateTime('DeleteDate')->nullable();
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidFile','PK_DataFiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_files');
    }
}
