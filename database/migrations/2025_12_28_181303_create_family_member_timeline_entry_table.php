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
        Schema::create('family_member_timeline_entry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('timeline_entry_id')->constrained()->cascadeOnDelete();
            $table->string('role')->nullable(); // celebrant, attendee, mentioned, etc.
            $table->timestamps();

            $table->unique(['family_member_id', 'timeline_entry_id'], 'unique_member_entry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_member_timeline_entry');
    }
};
