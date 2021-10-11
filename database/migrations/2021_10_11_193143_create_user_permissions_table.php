<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->char('NidPermission',38)->collation('utf8mb4_persian_ci');
            $table->char('UserId',38)->collation('utf8mb4_persian_ci');
            $table->char('ResourceId',38)->collation('utf8mb4_persian_ci');
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidPermission','PK_UserPermissions');
            $table->foreign('UserId','FK_UserUserPermission')->references('NidUser')->on('User');
            $table->foreign('ResourceId','FK_ResourceUserPermission')->references('NidResource')->on('Resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permissions');
    }
}
