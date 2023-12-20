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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('sponsor_id');
            $table->integer('client_id');
            $table->date('loan_date');//data do empréstimo
            $table->decimal('amount_original', $precision = 8, $scale = 2);//valor do empréstimo original
            $table->decimal('amount', $precision = 8, $scale = 2);//valor do empréstimo
            $table->decimal('fees', $precision = 8, $scale = 2);//juros do emprestimo
            $table->decimal('total_paid', $precision = 8, $scale = 2)->default(0)->nullable();//total_pago
            $table->enum('status', ['Aberto', 'Fechado'])->default('Aberto');
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
        Schema::dropIfExists('loans');
    }
};
