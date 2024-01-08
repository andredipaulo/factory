<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Exception;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public $loan;
    public $viewEdit;
    public $viewCreate;

    public function __construct(Loan $loan)
    {
        $this->loan      = $loan;
        $this->viewEdit     = 'loans.edit';
        $this->viewCreate   = 'loans.create';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::where('status', 'Aberto')
            //** colocar no DataTable da view em  "order": [[0, 'asc']] // Onde 0 é o índice da coluna "#" e 'asc' é para ascendente */
            ->orderBy('loan_date', 'asc')
            ->get();

        foreach ($loans as $loan) {
            $client[]   = $loan->client;
            $sponsor[]  = $loan->sponsor;
            $payments[] = $loan->payments;
        }

        return view('loans.index', compact(['loans']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->input('loans') as $loanData) {
                // Use a função date() para formatar a data
                $data_formatada = date("Y-m-d", strtotime(str_replace("/", "-", $loanData['loan_date'])));

                $loan = new Loan();
                $loan->sponsor_id     = $loanData['sponsor'];
                $loan->client_id      = $loanData['client'];
                $loan->amount_original= $loanData['amount'];
                $loan->amount         = $loanData['amount'];
                $loan->fees           = $loanData['fees'];
                $loan->loan_date      = $data_formatada;

                $loan->save();
            }

            return response()->json([
                'message' => 'Dados salvos com sucesso',
                'dados' => $loan
            ]);
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
        try {
            $loan = Loan::find($id);

            $client = $loan->client;
            $sponsor = $loan->sponsor;
            $payments[] = $loan->payments;

            // Carrega o conteúdo do arquivo blade.php
            $bladeContent = view($this->viewEdit, compact('loan'))->render();

            echo json_encode([
                'content' => $bladeContent,
                'loan' => $loan,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao recuperar os dados',
            ], 500);
        }
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
        $data = $request->all();

        $data['amount_original'] = $data['amount_original'] ? str_replace(",", ".", str_replace(".", "", $data['amount_original'])) : null;
        $data['amount'] = $data['amount'] ? str_replace(",", ".", str_replace(".", "", $data['amount'])) : null;
        $data['total_paid'] = $data['total_paid'] ? str_replace(",", ".", str_replace(".", "", $data['total_paid'])) : 0;
        $data['fees'] = $data['fees'] ? str_replace(",", ".", str_replace(".", "", $data['fees'])) : null;

        $id = $request->input("id");

        $loan = Loan::find($id);

        $loan->update($data);
        return redirect('loans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);
        $payments = $loan->payments;
        if (count($payments) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Empréstimo possuí pagamento(s)'
            ]);
        }else{
            $loan->delete();
            return response()->json(['success' => true]);
        }
    }

    public function getLoan($id){

        $loan = Loan::find($id);

        $client[]   = $loan->client;
        $sponsor[] = $loan->sponsor;

        if($loan){
            echo json_encode($loan);
        }else{
            echo json_encode(array());
        }
    }

    public function list()
    {
        $loans = Loan::where('status', 'Aberto')
            ->orderBy('loan_date', 'asc')
            ->get();

        foreach ($loans as $loan) {
            $client[]   = $loan->client;
            $sponsor[]  = $loan->sponsor;
            $payments[] = $loan->payments;
        }

        //return $clients->toJson();
        return response()->json([
            'data' => $loans,
        ], 200);
    }

    public function new(Request $request)
    {
        try {
            // Valide os dados da solicitação
            $validatedData = $request->validate([
                'sponsor_id' => 'required',
                'client_id' => 'required',
                'amount_original' => 'required',
                'amount' => 'required',
                'fees' => 'required',
                'total_paid' => 'required',
                'loan_date' => 'required',
            ]);

            // Converta o campo para um formato numérico
            $validatedData['amount_original'] = str_replace(',', '.', str_replace('.', '', $validatedData['amount_original']));
            $validatedData['amount'] = str_replace(',', '.', str_replace('.', '', $validatedData['amount']));
            $validatedData['total_paid'] = str_replace(',', '.', str_replace('.', '', $validatedData['total_paid']));

            // Crie um novo registro no banco de dados
            $loan = Loan::create($validatedData);

            //return $client->toJson();
            return response()->json([
                'data' => $loan,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados' .$e,
            ], 500);
        }
    }
    public function loan($id)
    {
        try {
            $loan = Loan::find($id);

            $client = $loan->client;
            $sponsor = $loan->sponsor;
            $payments[] = $loan->payments;

            return response()->json([
                'data' => $loan,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao recuperar os dados',
            ], 500);
        }
    }

    public function up($id, Request $request)
    {

        $data = $request->all();

        // Converta o campo para um formato numérico
        $data['amount_original'] = str_replace(',', '.', str_replace('.', '', $data['amount_original']));
        $data['amount'] = str_replace(',', '.', str_replace('.', '', $data['amount']));
        $data['total_paid'] = str_replace(',', '.', str_replace('.', '', $data['total_paid']));


        if( $id == $request->input("id") ){
            $loan = Loan::find($id);
            $loan->update($data);

            //return $client->toJson();

            return response()->json([
                'data' => $loan,
            ], 200);
        }else {
            return response()->json([
                'fail' => true,
                'info' => 'Verifique os dados do cliente. (id)'
            ]);
        }
    }
    public function del($id)
    {
        $loan = Loan::find($id);

        $payments = $loan->payments;

        if (count($payments) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Empréstimo possuí pagamento(s)'
            ]);

        }else{
            $loan->delete();
            return response()->json(['success' => true]);
        }

    }

    public function simulador()
    {


    }
}
