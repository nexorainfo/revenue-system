<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('email', function (Blueprint $table) {
                $table->string('designation')->nullable();
                $table->string('phone')->nullable();
                $table->string('profile_photo_path')->nullable();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('role_id')->constrained()->cascadeOnDelete();
                $table->boolean('is_active')->default(1);
                $table->softDeletes();
            });
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'is_active', 'ward_no', 'designation', 'profile_photo_path']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('role_id');
            $table->dropSoftDeletes();
        });
    }
};
