<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('letter_heads', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            $table->longText('header')->nullable();
            $table->longText('letter_head')->nullable();
            $table->longText('header_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('letter_heads');
    }
};
