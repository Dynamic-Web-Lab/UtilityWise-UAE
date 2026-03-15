<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider', 32);
            $table->decimal('amount', 12, 2);
            $table->date('bill_date');
            $table->decimal('consumption_kwh', 12, 2)->nullable();
            $table->decimal('consumption_gallons', 12, 2)->nullable();
            $table->json('raw_data')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::create('consumption_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bill_id')->nullable()->constrained()->nullOnDelete();
            $table->date('record_date');
            $table->decimal('kwh', 12, 2)->default(0);
            $table->decimal('gallons', 12, 2)->default(0);
            $table->decimal('amount_aed', 12, 2)->default(0);
            $table->string('provider', 32)->nullable();
            $table->timestamps();
        });

        Schema::create('alerts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bill_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 32);
            $table->text('message');
            $table->decimal('threshold_percent', 5, 2)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('consumption_records');
        Schema::dropIfExists('bills');
    }
};
