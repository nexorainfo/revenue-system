<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revenue_category_id')->comment('राजस्वको प्रकार')->nullable()->constrained('revenue_categories')->cascadeOnDelete();
            $table->string('code_no')->comment('कोड नं.')->nullable();
            $table->string('title')->comment('शिर्षक');
            $table->text('description')->comment('विवरण')->nullable();
            $table->double('amount')->comment('दर')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->comment('कैफियत')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenues');
    }
};
