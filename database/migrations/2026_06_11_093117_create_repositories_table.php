<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('author');
            $table->string('nim')->nullable();
            $table->string('supervisor')->nullable();
            $table->year('year')->nullable();

            $table->string('type')->default('skripsi');
            $table->text('abstract')->nullable();
            $table->string('pdf_file')->nullable();

            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositories');
    }
};
