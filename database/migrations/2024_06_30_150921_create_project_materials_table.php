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
        Schema::create('project_materials', function (Blueprint $table) {
            $table->id();
            $table->string('projectNo', 24);
            $table->unsignedBigInteger('materialId');
            $table->integer('qty');
            $table->string('price', 16);
            $table->string('customPrice', 16);
            $table->enum('deliveryStatus', ['PENDING', 'PROCESSING', 'DELIVERED', 'FAILED', 'RETURNED', 'REPLACED']);
            $table->integer('remainingQty');
            $table->timestamps();
            $table->foreign('projectNo')->references('projectNo')->on('projects')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('materialId')->references('id')->on('materials')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_materials');
    }
};
