<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookStocksTable extends Migration {
    public function up() {
        Schema::create('book_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id'); // Entity ID (e.g., DLC or ALC)
            $table->string('title');
            $table->string('author');
            $table->string('isbn');
            $table->date('published_date');
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('book_stocks');
    }
}

