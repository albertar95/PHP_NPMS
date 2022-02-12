<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_permissions', function (Blueprint $table) {
            // $table->dropForeign('FK_ResourceUserPermission');
            $table->integer('EntityId');
            $table->boolean('Create')->default(false);
            $table->boolean('Edit')->default(false);
            $table->boolean('Delete')->default(false);
            $table->boolean('Detail')->default(false);
            $table->boolean('List')->default(false);
            $table->boolean('Print')->default(false);
            $table->boolean('Confident')->default(false);
            $table->dropPrimary();
            $table->primary(['UserId','EntityId'],'PK_UserPermissions3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
