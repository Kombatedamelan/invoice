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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            
            // Date de la facture
            $table->date('date');
            
            // Numéro de facture unique
            $table->string('invoice_number')->unique();
            
            // Informations client
            $table->string('client');
            
            // Bon de commande (optionnel)
            $table->string('order_number')->nullable();
            
            // Objet de la facture (sans limite de caractères)
            $table->text('object');
            
            // Lignes de facture (stockées en JSON)
            $table->json('lines')->nullable();
            
            // Montant total
            $table->decimal('total_amount', 15, 0)->default(0);
            
            // Montant en lettres
            $table->string('amount_in_words')->nullable();
            
            // Statut de la facture
            $table->enum('status', ['payée', 'en attente', 'en retard'])->default('en attente');
            
            // Timestamps
            $table->timestamps();
            
            // Index pour les recherches
            $table->index('invoice_number');
            $table->index('client');
            $table->index('status');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};