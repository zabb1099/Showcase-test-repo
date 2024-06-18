<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jobs_Parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('audit_id');
            $table->foreign('audit_id')->references('id')->on('Jobs_Audit');
            $table->string('parameter_name', 50);
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Jobs_Parameters');
    }
}
