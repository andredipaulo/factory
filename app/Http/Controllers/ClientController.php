<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientFormRequest;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public $client;
    public $viewEdit;
    public $viewCreate;
    public function __construct(Client $client)
    {
        $this->client       =  $client;
        $this->viewEdit     = 'clients.edit';
        $this->viewCreate   = 'clients.create';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //  $search = $request->pesquisar;
        //  $clients = $this->client->getClients(search: $search ?? "");

        $clients = Client::with(['loans' => function ($query) {
            $query->where('status', 'Aberto');
        }])
            ->get();

        foreach ($clients as $client)
        {
            $loans = $client->loans;

            foreach ($loans as $loan) {
                $sponsor[] = $loan->sponsor;
                $payments[] = $loan->payments;
            }
        }
        return view('clients.index', compact(['clients']));
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
    public function store(ClientFormRequest $request)
    {
        $data = $request->all();
        $data['limit'] = $data['limit'] ? str_replace(",", ".", str_replace(".", "", $data['limit'])) : 0;

        Client::create($data);
        return redirect('clients');

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
            $client = Client::where('id',$id)
                ->with(['loans' => function ($query) {
                    $query->where('status', 'Aberto');
                }])
                ->get();

            foreach ($client as $client)
            {
                $loans = $client->loans;

                foreach ($loans as $loan) {
                    $sponsor[] = $loan->sponsor;
                    $payments[] = $loan->payments;
                }
            }

            //debugar
            //echo json_encode($client); die;

            // Carrega o conteúdo do arquivo blade.php
            $bladeContent = view($this->viewEdit, compact('client'))->render();

            echo json_encode([
                'content' => $bladeContent,
                'client' =>$client,
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
    public function update(Request $request)
    {
        $data = $request->all();
        $data['limit'] = str_replace(",", ".", str_replace(".", "", $data['limit']));

        $id = $request->input("id");

        $client = Client::find($id);
        $client->update($data);
        return redirect('clients');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        $loans = $client->loans;

        if (count($loans) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Cliente possuí empréstimo(s)'
            ]);
        }else{
            $client->delete();
            return response()->json(['success' => true]);
        }

    }

    public function getClientData($id)
    {
        $client = Client::find($id);

        if($client){
            echo json_encode($client);
        }else{
            echo json_encode(array());
        }
    }

    public function list()
    {
        $clients = Client::with(['loans' => function ($query) {
            /*$query->where('status', 'Aberto');*/
        }])
            ->get();

        foreach ($clients as $client)
        {
            $loans = $client->loans;

            foreach ($loans as $loan) {
                $sponsor[] = $loan->sponsor;
                $payments[] = $loan->payments;
            }
        }
        //return $clients->toJson();
        return response()->json([
            'data' => $clients,
        ], 200);
    }

    public function new(Request $request)
    {
        try {
            // Valide os dados da solicitação
            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => '',
                'email' => '',
                'ddd' => '',
                'phone' => '',
                'street_name' => '',
                'address' => '',
                'complement' => '',
                'neighborhood' => '',
                'city' => '',
                'state' => '',
                'limit' => '',
                'postcode' => '',
                'status' => '',
                'observation' => ''
            ]);

            // Converta o campo 'limit' para um formato numérico
            $validatedData['limit'] = str_replace(',', '.', str_replace('.', '', $validatedData['limit']));

            // Crie um novo registro no banco de dados
            $client = Client::create($validatedData);
            //return $client->toJson();
            return response()->json([
                'data' => $client,
            ], 201);


        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados',
            ], 500);
        }
    }

    public function client($id)
    {
        try {
            $client = Client::where('id',$id)
                ->with(['loans' => function ($query) {
                    $query->where('status', 'Aberto');
                }])
                ->get();

            foreach ($client as $client)
            {
                $loans = $client->loans;

                foreach ($loans as $loan) {
                    $sponsor[] = $loan->sponsor;
                    $payments[] = $loan->payments;
                }
            }

            //  return response()->json([
            //      'data' => $client,
            //  ], 200);
            return $client->toJson();

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao recuperar os dados',
            ], 500);
        }
    }

    public function up($id, Request $request)
    {

        $data = $request->all();
        // $data['limit'] = ($data['limit']) ? str_replace(",", ".", str_replace(".", "", $data['limit'])) : 0;


        if( $id == $request->input("id") ){
            $client = Client::find($id);
            $client->update($data);

            //  return response()->json([
            //      'data' => $client,
            //  ], 200);
            return $client->toJson();

        }else {
            return response()->json([
                'fail' => true,
                'info' => 'Verifique os dados do cliente. (id)'
            ]);
        }
    }
    public function del($id)
    {
        $client = Client::find($id);

        $loans = $client->loans;

        if (count($loans) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Cliente possuí empréstimo(s)'
            ]);
        }else{
            $client->delete();
            return response()->json(['success' => true]);
        }

    }
}
