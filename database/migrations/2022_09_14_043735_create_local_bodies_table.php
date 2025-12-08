<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('local_bodies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->string('local_body')->comment('स्थानीय निकाय');
            $table->string('local_body_en')->nullable()->comment('स्थानीय निकाय (अंग्रेजीमा)');
            $table->integer('wards');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_bodies');
    }
};
