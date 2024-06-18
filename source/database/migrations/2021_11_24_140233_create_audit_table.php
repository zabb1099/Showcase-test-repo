<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jobs_Audit', function (Blueprint $table) {
            $table->id();
            $table->string('job_name', 100);
            $table->integer('changed_by');
            $table->dateTime('changed_at');
            $table->string('reason_changed', 255);
            $table->string('action_type', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Jobs_Audit');
    }
}
