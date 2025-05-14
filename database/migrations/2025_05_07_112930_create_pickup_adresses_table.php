adresses_table.php
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
        Schema::create('pickup_adresses', function (Blueprint $table) {
            $table->id(); // Id (PK)
            $table->string('street_name'); // Street name
            $table->string('house_number'); // House number
            $table->string('addition')->nullable(); // Addition
            $table->string('postcode'); // Postcode
            $table->string('place'); // Place
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
        Schema::dropIfExists('pickup_adresses');
    }
};