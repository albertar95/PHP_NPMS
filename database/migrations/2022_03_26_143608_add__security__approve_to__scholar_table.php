<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityApproveToScholarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->boolean('IsSecurityApproved')->nullable(false)->default(false);
            $table->string('SecurityApproveDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scholars', function (Blueprint $table) {
            $table->boolean('IsSecurityApproved')->nullable(false)->default(false);
            $table->string('SecurityApproveDate',25)->nullable(true)->collation('utf8mb4_persian_ci');
        });
    }
}
