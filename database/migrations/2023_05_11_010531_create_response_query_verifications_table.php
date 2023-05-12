<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('response_query_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('query_id')->constrained();
            $table->string('statusCode')->nullable();
            $table->string('statusMessage')->nullable();
            $table->string('statusRequestMessage')->nullable();
            $table->string('statusRequestName')->nullable();
            $table->integer('statusRequestEntryIndex')->nullable();
            $table->integer('codeRequestValue')->nullable();
            $table->string('codeRequestName')->nullable();
            $table->string('codeRequestMessage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_query_verifications');
    }
};
