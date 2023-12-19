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
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->foreignId("brand_id")->constrained("brands");
            $table->string("year", 4);
            $table->string("price", 100);
            $table->string("description", 1000);
            $table->string("image");
            $table->integer("stock")->default(0);
            $table->integer("total_sales")->default(0);
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
        Schema::dropIfExists('consoles');
    }
};
