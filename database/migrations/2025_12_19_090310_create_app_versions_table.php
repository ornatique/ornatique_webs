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
       Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // android / ios
            $table->string('version');  // 1.0.1
            $table->boolean('force_update')->default(false);
            $table->text('message')->nullable();
            $table->string('store_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_versions');
    }
};
