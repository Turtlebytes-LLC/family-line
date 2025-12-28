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
        Schema::create('timeline_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Event details
            $table->string('title');
            $table->longText('content')->nullable();
            $table->date('event_date')->nullable();
            $table->date('event_end_date')->nullable(); // For events spanning multiple days
            $table->string('event_type')->default('story'); // story, birth, death, marriage, milestone, photo, document

            // Location (optional)
            $table->string('location')->nullable();

            // People involved (JSON array of names/user IDs)
            $table->json('people_involved')->nullable();

            // Family surname for permission scoping
            $table->string('family_surname')->nullable()->index();

            // Media/attachments will be handled via Spatie Media Library or separate table
            $table->boolean('has_audio')->default(false);
            $table->text('audio_transcript')->nullable();

            // Visibility
            $table->enum('visibility', ['immediate_family', 'extended_family', 'private'])->default('immediate_family');
            $table->boolean('is_published')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes for timeline queries
            $table->index('event_date');
            $table->index(['team_id', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_entries');
    }
};
