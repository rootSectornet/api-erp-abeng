<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarys', function (Blueprint $table) {
            $table->id();
            $table->string('type', 16);
            $table->string('salary', 16);
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade')->onUpdate('no action');
            $table->boolean('is_active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_dt')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salarys');
    }
}
