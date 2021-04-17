<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('boards', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });
        
        Schema::table('invitations', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        Schema::table('links', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        Schema::table('memberships', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable();
        });
    }
};
