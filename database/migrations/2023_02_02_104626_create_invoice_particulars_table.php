<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::create('invoice_particulars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('revenue_category_id')->nullable()->constrained('revenue_categories')->nullOnDelete();
            $table->foreignId('revenue_id')->nullable()->constrained('revenues')->nullOnDelete();
            $table->text('revenue')->comment('विवरण');
            $table->double('quantity')->comment('परिमाण')->default(0);
            $table->double('rate')->comment('दर')->default(0);
            $table->integer('due')->comment('बाकि')->default(0);
            $table->string('remarks')->comment('कैफियत')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_particulars');
    }
};
