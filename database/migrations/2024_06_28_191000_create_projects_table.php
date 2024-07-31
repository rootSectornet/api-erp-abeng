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
        Schema::create('projects', function (Blueprint $table) {
            $table->string('projectNo', 24)->primary();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('no action');
            $table->foreignId('customer_id')->constrained('costumers')->onDelete('cascade')->onUpdate('no action');
            $table->string('amount',16);
            $table->string('transport_cost',16);
            $table->enum('type', ['OFFERING', 'SURVEY','NEGOSIATION','ACTIVE_PROJECT','DONE_PROJECT','CANCEL']);
            $table->boolean('is_active')->default(true);
            $table->text('reason')->nullable();
            $table->timestamp('survey_date')->useCurrent()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
