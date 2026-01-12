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
       Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // android / ios
            $table->string('min_supported_version'); // 1.0.5
            $table->string('latest_version'); // 1.0.6
            $table->string('store_url');
            $table->boolean('force_update')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
