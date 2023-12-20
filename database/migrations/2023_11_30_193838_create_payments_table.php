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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id');
            $table->date('payment_date');//data do empréstimo
            $table->decimal('amount', $precision = 8, $scale = 2)->nullable();//valor atual do emprestimo
            $table->decimal('amount_fees', $precision = 8, $scale = 2)->nullable();//valor pago do juros
            $table->decimal('amount_paid', $precision = 8, $scale = 2)->nullable();//valor pago do montante
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
