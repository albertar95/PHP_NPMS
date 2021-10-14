<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->char('NidPermission',38)->collation('utf8mb4_persian_ci');
            $table->char('RoleId',38)->collation('utf8mb4_persian_ci');
            $table->integer('EntityId');
            $table->boolean('Create')->default(false);
            $table->boolean('Edit')->default(false);
            $table->boolean('Delete')->default(false);
            $table->boolean('Detail')->default(false);
            $table->boolean('List')->default(false);
            $table->boolean('Print')->default(false);
            $table->collation = 'utf8mb4_persian_ci';
            $table->primary('NidPermission','PK_RolePermissions');
            $table->foreign('RoleId','FK_RoleRolePermission')->references('NidRole')->on('Roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
