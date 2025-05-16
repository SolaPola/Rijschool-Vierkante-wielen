addresses_table.php
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
        Schema::create('driving_lessons_per_pickup_addresses', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->foreignId('driving_lesson_id')->constrained('driving_lessons')->onDelete('cascade'); // Driving lesson ID (FK)
            $table->foreignId('pickup_address_id')->constrained('pickup_adresses')->onDelete('cascade'); // Pickup address ID (FK)
            $table->boolean('isactive')->default(true); // IsActive
            $table->text('remark')->nullable(); // Remark
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_lessons__per__pickup__addresses');
    }
};