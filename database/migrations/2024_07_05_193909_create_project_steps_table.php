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
        Schema::create('project_steps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('rank');
            $table->enum('status', ['DONE', 'PENDING', 'RUNNING', 'STOP', 'SKIPPED', 'ON-HOLD']);
            $table->integer('duration');
            $table->string('projectNo', 24);
            $table->timestamps();
            $table->foreign('projectNo')->references('projectNo')->on('projects')->onDelete('cascade')->onUpdate('no action');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_steps');
    }
};
