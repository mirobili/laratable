<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable2 extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();

            $table->decimal('price', 10, 2)->nullable();

            $table->string('alt_name')->nullable();
            $table->text('description')->nullable();
            $table->json('item_meta')->nullable();
            $table->string('image_url')->nullable();

            $table->string('product_type')->nullable();
            $table->text('qr_code')->nullable();

            $table->boolean('is_available')->default(true);

            $table->timestamps();

            // If you have foreign keys and want to use them uncomment below:
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            // $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
            // $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}

