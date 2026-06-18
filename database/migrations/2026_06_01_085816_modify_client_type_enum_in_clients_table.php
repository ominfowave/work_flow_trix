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
        Schema::table('clients', function (Blueprint $table) {
              DB::statement("
                ALTER TABLE clients
                MODIFY COLUMN client_type
                ENUM('approved', 'unapproved', 'accept', 'reject')
                NOT NULL DEFAULT 'unapproved'
            ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
             DB::statement("
                ALTER TABLE clients
                MODIFY COLUMN client_type
                ENUM('approved', 'unapproved')
                NOT NULL DEFAULT 'unapproved'
            ");
        });
    }
};
