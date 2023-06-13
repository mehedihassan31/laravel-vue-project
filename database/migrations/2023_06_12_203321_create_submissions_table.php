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
        Schema::create('submissions', function (Blueprint $table) {

                $table->id();
                $table->integer('amount');
                $table->string('buyer', 20);
                $table->string('receipt_id', 20);
                $table->string('items', 255);
                $table->string('buyer_email', 50);
                $table->string('buyer_ip', 20);
                $table->text('note');
                $table->string('city', 20);
                $table->string('phone', 20);
                $table->string('hash_key', 255);
                $table->date('entry_at');
                $table->integer('entry_by');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
