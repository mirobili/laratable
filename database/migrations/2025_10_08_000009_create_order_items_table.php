<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('serving')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamp('create_stamp')->useCurrent();
            $table->timestamp('confirm_stamp')->nullable();
            $table->foreignId('confirm_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('complete_stamp')->nullable();
            $table->timestamp('delivery_stamp')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
