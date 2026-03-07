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
    Schema::create('cotisations', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->decimal('montant', 10, 2);
        $table->string('description')->nullable();
        $table->string('justificatif');

        $table->enum('statut', ['en_attente', 'validee', 'rejetee'])
              ->default('en_attente');

        $table->date('date_cotisation');

        $table->timestamps();

        $table->index(['user_id', 'date_cotisation', 'statut']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
