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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shelf_id')->nullable()->constrained('shelves')->nullOnDelete();

            $table->string('code')->unique();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->year('year')->nullable();
            $table->string('isbn')->nullable();

            $table->integer('stock')->default(1);
            $table->integer('available_stock')->default(1);

            $table->string('cover')->nullable();
            $table->string('ebook_file')->nullable();

            $table->boolean('is_digital')->default(false);
            $table->boolean('can_borrow')->default(true);
            $table->integer('view_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
