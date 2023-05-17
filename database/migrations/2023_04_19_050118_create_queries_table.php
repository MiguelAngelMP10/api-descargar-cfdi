<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('rfc');
            $table->enum('endPoint', ['cfdi', 'retenciones'])->default('cfdi');
            $table->enum('downloadType', ['issued', 'received'])->default('issued');
            $table->enum('requestType', ['xml', 'metadata'])->default('metadata');

            $table->dateTime('dateTimePeriodStart');
            $table->dateTime('dateTimePeriodEnd');
            $table->uuid('requestId')->nullable();
            $table->integer('numeroCFDIs')->nullable();

            $table->enum('documentType', ['', 'I', 'E', 'N', 'T', 'P'])->nullable();
            $table->enum('documentStatus', ['', 'active', 'cancelled'])->nullable();
            $table->string('complementoCfdi')->nullable();
            $table->json('rfcMatches')->default(new Expression('(JSON_ARRAY())'));
            $table->uuid('uuid')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
