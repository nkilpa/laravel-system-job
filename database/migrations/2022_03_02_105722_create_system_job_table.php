<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->dateTime('scheduled_at');
            $table->dateTime('executed_at')->nullable();
            $table->integer('attempts');
            $table->json('params')->nullable();
            $table->string('status');
            $table->string('driver');
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
        Schema::dropIfExists('system_job');
    }
};
