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
        
          Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->string('User_Name');
            $table->string('Ticket_Subject');
            $table->string('Ticket_Category');
            $table->string('Ticket_Description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
