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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');

            $table->integer('sender_id');
            $table->integer('receiver_id');

            $table->string('title');
            $table->string('message');
            
            $table->string('notification_label')->nullable();

            $table->integer('table_id');
            $table->string('table_name');

            $table->enum('is_read',[0,1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
