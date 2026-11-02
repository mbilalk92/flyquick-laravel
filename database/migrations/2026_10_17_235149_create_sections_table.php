<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Global reusable sections (e.g. "Homepage Hero", "FAQ Block")
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // human label in admin
            $table->string('type');           // hero, features, services, offers, faq, cta, support, testimonial, rich_text, etc.
            $table->json('data')->nullable(); // all section content as JSON
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
