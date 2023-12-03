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
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_contact')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_detail1')->nullable();
            $table->string('business_detail2')->nullable();
            $table->string('business_detail3')->nullable();
            $table->string('business_extra1')->nullable();
            $table->string('business_extra2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
