<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            -- SQL para criar a trigger update_loan_amount
            CREATE TRIGGER update_loan_amount AFTER INSERT ON payments
            FOR EACH ROW
            BEGIN
                IF NEW.amount_paid IS NOT NULL THEN
                    UPDATE loans
                    SET amount = amount - NEW.amount_paid, total_paid = total_paid + NEW.amount_paid
                    WHERE id = NEW.loan_id;

                    IF (SELECT total_paid FROM loans WHERE id = NEW.loan_id) >= (SELECT amount_original FROM loans WHERE id = NEW.loan_id) THEN
                        UPDATE loans
                        SET status = "Fechado"
                        WHERE id = NEW.loan_id;
                    END IF;
                END IF;
            END;
        ');

        DB::unprepared('
            -- SQL para criar a trigger delete_payment_update_loan_amount
            CREATE TRIGGER delete_payment_update_loan_amount AFTER DELETE ON payments
            FOR EACH ROW
            BEGIN
                IF OLD.amount_paid IS NOT NULL THEN
                    UPDATE loans
                    SET amount = amount + OLD.amount_paid, total_paid = total_paid - OLD.amount_paid
                    WHERE id = OLD.loan_id;

                    IF (SELECT total_paid FROM loans WHERE id = OLD.loan_id) < (SELECT amount_original FROM loans WHERE id = OLD.loan_id) THEN
                        UPDATE loans
                        SET status = "Aberto"
                        WHERE id = OLD.loan_id;
                    END IF;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_loan_amount');
        DB::unprepared('DROP TRIGGER IF EXISTS delete_payment_update_loan_amount');
    }
};
