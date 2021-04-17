<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id');
            $table->text('url');
            $table->text('title');
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }
};
