<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jobs_Fields', function (Blueprint $table) {
            $table->id();
            $table->integer('audit_id');
            $table->foreign('audit_id')->references('id')->on('Jobs_Audit');
            $table->string('primary_key', 255)->nullable();
            $table->string('database_name', 50);
            $table->string('table_name', 100)->nullable();
            $table->string('field_name', 50);
            $table->string('old_value', 255);
            $table->string('new_value', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Jobs_Fields');
    }
}
