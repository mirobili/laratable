<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('message');
            $table->string('message_to'); // employee_id or 'all' or role
            $table->enum('type', ['order', 'service', 'system'])->default('order');
            $table->enum('status', ['pending', 'sent', 'read', 'acknowledged'])->default('pending');
            $table->timestamp('stamp')->useCurrent();
            $table->timestamp('confirmed_stamp')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
