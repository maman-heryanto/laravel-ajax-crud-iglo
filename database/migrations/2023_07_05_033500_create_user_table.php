<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('email')->unique();
            $table->text('password')->nullable();
            $table->string('role')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->char('created_by', 36)->nullable();
            $table->char('update_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};