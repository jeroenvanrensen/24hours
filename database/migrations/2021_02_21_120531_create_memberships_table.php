<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('board_id');
            $table->string('role');
            $table->timestamps();
        });
    }
}
