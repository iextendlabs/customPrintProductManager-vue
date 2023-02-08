<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('name')->nullable();
            $table->string('driveLink')->nullable();
            $table->string('sku')->nullable();
            $table->string('daraz')->nullable();
            $table->string('decorguys')->nullable();
            $table->string('carstickers')->nullable();
            $table->string('image')->nullable();
            $table->string('artcutFile')->nullable();
            $table->string('otherArtcutFile')->nullable();
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
}
