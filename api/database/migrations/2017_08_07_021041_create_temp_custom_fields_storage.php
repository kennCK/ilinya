<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempCustomFieldsStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('temp_custom_fields_storage');
        Schema::create('temp_custom_fields_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('facebook_id');
            $table->string('field_name',100);
            $table->string('field_value');
            $table->timestamps();
            $table->softDeletes();
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
