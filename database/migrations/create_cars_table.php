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
        if (!Schema::hasTable('cars')) {
            Schema::create('cars', function (Blueprint $table) {
                $table->id();
                $table->string('brand', 100);
                $table->string('type', 100);
                $table->string('license_plate', 20)->unique();
                $table->enum('fuel', ['petrol', 'diesel', 'electric', 'hybrid']);
                $table->boolean('isactive')->default(true);
                $table->text('remark')->nullable();
                $table->string('maintenance_reason')->nullable();
                $table->date('maintenance_until')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
