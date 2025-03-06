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
        Schema::create('wastes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('type_id')->constrained('waste_types')->onDelete('cascade');
            $table->text('description');
            $table->integer('quantity');
            $table->enum('unit', ['T', 'Kg', 'L', 'm³']);
            $table->enum('classification', ['Ordinario', 'Reciclable', 'Peligroso']);
            $table->enum('state', ['Solido', 'Liquido', 'Gaseoso']);
            $table->enum('origin', ['Industrial', 'Comercial', 'Residencial']);
            $table->enum('type', ['Generado', 'Reciclado', 'Eliminado']);
            $table->enum('status', ['Pendiente', 'Recolectado', 'Procesado', 'Eliminado']);
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
        Schema::dropIfExists('wastes');
    }
};
