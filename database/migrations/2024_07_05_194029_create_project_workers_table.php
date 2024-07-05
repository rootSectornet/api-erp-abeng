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
        Schema::create('project_workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ProjectStepId');
            $table->unsignedBigInteger('positionId');
            $table->integer('total');
            $table->string('salary', 16);
            $table->timestamps();
            $table->foreign('ProjectStepId')->references('id')->on('project_steps')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('positionId')->references('id')->on('positions')->onDelete('cascade')->onUpdate('no action');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_workers');
    }
};
