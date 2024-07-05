<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2); // Adjust precision and scale as needed
            $table->string('unit');
            $table->enum('type', ['BERAT', 'RINGAN']);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_dt')->useCurrent()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
