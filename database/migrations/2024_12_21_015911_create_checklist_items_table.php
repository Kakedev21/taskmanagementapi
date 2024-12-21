<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('checklist_items', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->boolean('is_completed')->default(false);
        $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
        $table->integer('position');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_items');
    }
};