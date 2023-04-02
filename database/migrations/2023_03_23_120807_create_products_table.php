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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->bigInteger('stock')->default(0);
            $table->integer('price')->default(0);;
            $table->integer('sale_price')->nullable(true);
            $table->string('description')->nullable(true);
            $table->text('content')->nullable(true);
            $table->integer('category_id')->nullable(true);
            $table->integer('is_active')->default(1);
            $table->integer('is_hot')->default(0);
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
        Schema::dropIfExists('products');
    }
};
