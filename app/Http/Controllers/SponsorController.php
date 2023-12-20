<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Exception;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public $sponsor;

    public $viewEdit;

    public $viewCreate;

    public function __construct(Sponsor $sponsor)
    {
        $this->sponsor = $sponsor;
        $this->viewEdit = 'sponsors.edit';
        $this->viewCreate = 'sponsors.create';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsor::with([
            'loans' => function ($query) {
                $query->where('status', 'Aberto');
            }
        ])
            ->get();

        foreach ($sponsors as $sponsor)
        {
            $loans = $sponsor->loans;

            foreach ($loans as $loan) {
                $client[]   = $loan->client;
                $payments[] = $loan->payments;
            }
        }
        return view('sponsors.index', compact(['sponsors']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Carrega o conteúdo do arquivo blade.php
        $view = view($this->viewCreate)->render();
        echo json_encode([
            'content' => $view
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
        $data = $request->all();
        Sponsor::create($data);

        return redirect('sponsors');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sponsors = Sponsor::where('id', $id)
            ->with(['loans' => function ($query) {
                $query->where('status', 'Aberto');
            }])
            ->get();

        foreach ($sponsors as $sponsor)
        {
            $loans = $sponsor->loans;

            foreach ($loans as $loan) {
                $client[]   = $loan->client;
                $payments[] = $loan->payments;
            }
        }

        // Carrega o conteúdo do arquivo blade.php
        $view = view($this->viewEdit, compact('sponsor'))->render();

        echo json_encode([
            'content' => $view,
            'sponsor' => $sponsor
        ]);
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
        $id = $request->input("id");

        $data = $request->all();
        $model = Sponsor::find($id);
        $model->update($data);

        return redirect('sponsors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::find($id);
        $loans = $sponsor->loans;

        if (count($loans) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Sponsor possuí cliente(s) com empréstimo(s)'
            ]);
        }else{
            $sponsor->delete();
            return response()->json(['success' => true]);
        }
    }

    public function list()
    {
        $sponsors = Sponsor::with(['loans' => function ($query) {
            $query->where('status', 'Aberto');
        }])
            ->get();

        foreach ($sponsors as $sponsor)
        {
            $loans = $sponsor->loans;

            foreach ($loans as $loan) {
                $client[]   = $loan->client;
                $payments[] = $loan->payments;
            }
        }

        //return $sponsors->toJson();
        return response()->json([
            'data' => $sponsors,
        ], 200);
    }

    public function new(Request $request)
    {
        try {
            // Valide os dados da solicitação
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => '',
                'status' => '',
            ]);

            // Crie um novo registro no banco de dados
            $sponsor = Sponsor::create($validatedData);

            //return $sponsor->toJson();
            return response()->json([
                'data' => $sponsor,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados',
            ], 500);
        }
    }

    public function sponsor($id)
    {
        try {
            $sponsor = Sponsor::where('id', $id)
                ->with(['loans' => function ($query) {
                    $query->where('status', 'Aberto');
                }])
                ->get();

                foreach ($sponsor as $sponsor)
                {
                    $loans = $sponsor->loans;

                    foreach ($loans as $loan) {
                        $client[]   = $loan->client;
                        $payments[] = $loan->payments;
                    }
                }

            //  echo json_encode([
            //    'sponsor' =>$sponsor,
            //  ]);
            return response()->json([
                'data' => $sponsor,
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

        if( $id == $request->input("id") ){
            $sponsor = Sponsor::find($id);
            $sponsor->update($data);

            //return $sponsor->toJson();
            return response()->json([
                'data' => $sponsor,
            ], 200);
        }else {
            return response()->json([
                'fail' => true,
                'info' => 'Verifique os dados do sponsor. (id)'
            ]);
        }
    }

    public function del($id)
    {
        $sponsor = Sponsor::find($id);

        $loans = $sponsor->loans;

        if (count($loans) > 0) {
            return response()->json([
                'fail' => true,
                'info' => 'Sponsor possuí empréstimo(s)'
            ]);
        }else{
            $sponsor->delete();
            return response()->json(['success' => true]);
        }

    }
}
