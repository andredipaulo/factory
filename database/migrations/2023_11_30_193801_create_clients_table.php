<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable(); #usuario@teste.com
            $table->string('phone')->nullable(); #9-9999-9999
            $table->string('address')->nullable(); #Rua 284
            $table->string('complement')->nullable(); #Numero 30 quadra 07 lote 09
            $table->string('neighborhood')->nullable(); #centro
            $table->string('city')->nullable(); #São Paulo
            $table->string('state')->nullable(); #São Paulo
            $table->string('postcode', 9)->nullable(); #74430020
            $table->decimal('limit', $precision = 8, $scale = 2)->default(0)->nullable();
            $table->enum('status', ['Ativo', 'Inativo'])->default("Ativo"); #ativo - inativo
            $table->text('observation')->nullable(); #campo texto para observação
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
