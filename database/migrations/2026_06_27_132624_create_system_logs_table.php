<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // HARUS menggunakan create() untuk membuat tabel baru
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('method', 10)->nullable();          
            $table->string('url', 2048)->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('aksi', 100)->nullable();        
            $table->integer('status_code')->nullable();
            $table->string('exception_class')->nullable();
            $table->text('exception_message')->nullable();
            $table->longText('exception_trace')->nullable();
            $table->boolean('is_error')->default(false);
            $table->json('context')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Cukup drop tabelnya jika di-rollback
        Schema::dropIfExists('system_logs');
    }
};