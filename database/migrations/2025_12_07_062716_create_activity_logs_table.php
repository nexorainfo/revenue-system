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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            $table->string('activity_type')->comment('गतिविधि प्रकार');
            $table->foreignId('user_id')->nullable()->comment('प्रयोगकर्ता ID')->constrained()->nullOnDelete();
            $table->ipAddress('ip');
            $table->string('agent');
            $table->boolean('is_seen')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
