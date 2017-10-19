<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAiTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ai', function (Blueprint $table) {
            $table->string('action_type', 100)->nullable()->after('answer');
            $table->string('answer', 500)->nullable()->change();
            $table->string('action', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ai', function (Blueprint $table) {
            //
        });
    }
}
