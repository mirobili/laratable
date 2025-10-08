<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('r_id'); // Reference ID
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('close_time')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->string('employee_name')->nullable();
            $table->enum('payment_method', ['cash', 'card', 'other'])->nullable();
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
