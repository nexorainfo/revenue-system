<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::create('revenue_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('शिर्षक');
            $table->foreignId('revenue_category_id')->nullable()->constrained('revenue_categories')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenue_categories');
    }
};
