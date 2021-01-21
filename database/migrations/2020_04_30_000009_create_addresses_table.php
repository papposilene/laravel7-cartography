<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name', 255);
            $table->text('owner', 255)->nullable();
            $table->text('address', 255);
            $table->boolean('status')->default(1);
            $table->text('description')->nullable();
            $table->string('url', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->point('latlng');
            $table->uuid('category_uuid');
            $table->foreign('category_uuid')
                ->references('uuid')->on('categories')->onDelete('cascade');
            $table->uuid('country_uuid');
            $table->foreign('country_uuid')
                ->references('uuid')->on('countries')->onDelete('cascade');
            $table->integer('place_id')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
