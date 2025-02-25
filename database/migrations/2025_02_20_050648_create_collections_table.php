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
        Schema::create('collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('waste_id')->constrained('wastes')->onDelete('cascade');
            $table->foreignId('collector_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('disposal_id')->constrained('disposals')->onDelete('cascade');
            $table->integer('quantity');
            $table->enum('unit', ['T', 'Kg', 'L', 'm³']);
            $table->enum('type', ['Generado', 'Reciclado', 'Eliminado']);
            $table->enum('classification', ['Ordinario', 'Reciclable', 'Peligroso']);
            $table->enum('state', ['Sólido', 'Líquido', 'Gaseoso']);
            $table->enum('origin', ['Industrial', 'Comercial', 'Residencial']);
            $table->enum('frequency', ['Diario', 'Semanal', 'Mensual']);
            $table->enum('schedule', ['Mañana', 'Tarde', 'Noche']);
            $table->enum('status', ['Programado', 'En camino', 'Completado']);
            $table->date('date');
            $table->string('location', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
