<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->comment('बिल नं.')->unique();
            $table->foreignId('fiscal_year_id')->comment('आर्थिक वर्ष')->constrained('fiscal_years');
            $table->foreignId('user_id')->comment('दाखिला गर्ने व्यक्ति')->constrained('users');
            $table->string('name')->comment('नाम');
            $table->string('address')->comment('ठेगाना');
            $table->string('payment_method')->comment('भुक्तानी बिधि');
            $table->string('reference_code')->comment('Reference Code')->nullable();
            $table->string('payment_date')->comment('भुक्तानी मिति');
            $table->string('payment_date_en')->comment('भुक्तानी मिति (ई.सं.)');
            $table->text('remarks')->comment('कैफियत')->nullable();
            $table->string('invoice_copy')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
