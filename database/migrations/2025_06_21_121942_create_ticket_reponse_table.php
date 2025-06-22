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
        Schema::create('ticket_reponse', function (Blueprint $table) {
             $table->id('ticket_response_id'); // custom primary key name
    $table->unsignedBigInteger('ticket_id'); // foreign key column
    $table->text('ticket_response');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_reponse');
    }
};
