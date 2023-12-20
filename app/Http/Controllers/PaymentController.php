<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public $payment;
    public $viewEdit;
    public $viewCreate;

    public function __construct(Payment $payment)
    {
        $this->payment      = $payment;
        $this->viewEdit     = 'payments.edit';
        $this->viewCreate   = 'payments.create';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['loan' => function ($query) {
            //$query->where('status', 'Aberto');
        }])->orderBy('payment_date')
            ->get();

        foreach ($payments as $payment){
            $loans[]   = $payment->loan;
            foreach ($loans as $loan) {
                $client[]   = $loan->client;
                $sponsor[] = $loan->sponsor;
            }
        }

        return view('payments.index', compact(['payments']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Carrega o conteúdo do arquivo blade.php
        $bladeContent = view($this->viewCreate)->render();
        echo json_encode([
            'content' => $bladeContent
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentData =$request;


        try {


            // Use a função date() para formatar a data
            $paymentData['payment_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $paymentData['payment_date'])));
            // Use a função str_replace para formatar valores
            $paymentData['amount_fees'] = $paymentData['amount_fees'] ? str_replace(",", ".", str_replace(".", "", $paymentData['amount_fees'])) : null;
            $paymentData['amount_paid'] = $paymentData['amount_paid'] ? str_replace(",", ".", str_replace(".", "", $paymentData['amount_paid'])) : null;

            $payment = new Payment();
            $payment->loan_id = $paymentData['loan_id'];
            $payment->amount = $paymentData['amount'];
            $payment->payment_date = $paymentData['payment_date'];
            $payment->amount_fees = $paymentData['amount_fees'];
            $payment->amount_paid = $paymentData['amount_paid'];

            $payment->save();

            return redirect('payments');
            //            return response()->json([
            //                'message' => 'Dados salvos com sucesso'
            //            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados',
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if($payment){
            /**
             * Quando você está usando o Laravel e quer acionar as triggers do banco de dados ao excluir um registro,
             * o método delete() do Eloquent não irá acionar as triggers do banco de dados automaticamente.
             * O Laravel fornece uma maneira de executar instruções SQL personalizadas, incluindo instruções SQL que
             * acionam as triggers. Para fazer isso, você pode usar o método DB::statement.
             * */
            DB::statement("DELETE FROM payments WHERE id = ?", [$id]);


            return response()->json(['success' => true]);
        }else{

            return response()->json(['fail' => true]);
        }
    }

    public function list()
    {
        $payments = Payment::with(['loan' => function ($query) {
            //$query->where('status', 'Aberto');
        }])->orderBy('payment_date')
            ->get();

        foreach ($payments as $payment){
            $loans[]   = $payment->loan;
            foreach ($loans as $loan) {
                $client[]   = $loan->client;
                $sponsor[] = $loan->sponsor;
            }
        }

        //return $clients->toJson();
        return response()->json([
            'data' => $payments,
        ], 200);
    }

    public function new(Request $request)
    {
        $paymentData =$request;

        try {

            // Use a função date() para formatar a data
            $paymentData['payment_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $paymentData['payment_date'])));
            // Use a função str_replace para formatar valores
            $paymentData['amount_fees'] = $paymentData['amount_fees'] ? str_replace(",", ".", str_replace(".", "", $paymentData['amount_fees'])) : null;
            $paymentData['amount_paid'] = $paymentData['amount_paid'] ? str_replace(",", ".", str_replace(".", "", $paymentData['amount_paid'])) : null;

            $payment = new Payment();
            $payment->loan_id = $paymentData['loan_id'];
            $payment->amount = $paymentData['amount'];
            $payment->payment_date = $paymentData['payment_date'];
            $payment->amount_fees = $paymentData['amount_fees'];
            $payment->amount_paid = $paymentData['amount_paid'];

            $payment->save();

            return response()->json([
                'data' => $payment,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados' .$e,
            ], 500);
        }
    }

    public function del($id)
    {
        $payment = Payment::find($id);

        if($payment){
            /**
             * Quando você está usando o Laravel e quer acionar as triggers do banco de dados ao excluir um registro,
             * o método delete() do Eloquent não irá acionar as triggers do banco de dados automaticamente.
             * O Laravel fornece uma maneira de executar instruções SQL personalizadas, incluindo instruções SQL que
             * acionam as triggers. Para fazer isso, você pode usar o método DB::statement.
             * */
            DB::statement("DELETE FROM payments WHERE id = ?", [$id]);


            return response()->json(['success' => true]);
        }else{

            return response()->json(['fail' => true]);
        }

    }
}
