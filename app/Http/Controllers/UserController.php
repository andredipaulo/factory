<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $user;
    public $viewEdit;
    public $viewCreate;

    public function __construct(User $user)
    {
        $this->user       =  $user;
        $this->viewEdit     = 'users.edit';
        $this->viewCreate   = 'users.create';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact(['users']));
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
        $data =  $request->all();

        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $fileName = md5( $image->getClientOriginalName()).'.'.$image->extension();
            $filePath = '/images/users';
            // Salvar a imagem na pasta
            $image->move(public_path($filePath ), $fileName);
            $data['photo'] = $fileName;
        }

        User::create($data);
        return redirect('users');
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
            $user = User::where('id', $id)->first();

            // Carrega o conteúdo do arquivo blade.php
            $view = view($this->viewEdit, compact('user'))->render();

            echo json_encode([
                'content' => $view,
                'user' => $user,
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

        $id = $data['id']; // Supondo que 'id' faça parte dos dados de entrada
        $user = User::find($id);

        if ($user) {

            if (!empty($request->password) &&
                !empty($request->password2) &&
                ($request->password === $request->password2)
            ) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']); // Remove a senha do array se não estiver definida
            }

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $fileName = md5($image->getClientOriginalName()).'.'.$image->extension();
                $filePath = '/images/users';
                // Salvar a imagem na pasta
                $image->move(public_path($filePath ), $fileName);
                $data['photo'] = $fileName;
            }

            $user->update($data);
            //Session::flash('flash_message', 'User successfully added!');
            return redirect('users');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list()
    {
        $users = User::all();

        //return $sponsors->toJson();
        return response()->json([
            'data' => $users,
        ], 200);
    }

    public function new(Request $request)
    {
        try {

            $request['password'] = Hash::make($request['password']);

            // Valide os dados da solicitação
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);


            // Crie um novo registro no banco de dados
            $user = User::create($validatedData);

            //return $sponsor->toJson();
            return response()->json([
                'data' => $user,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao salvar os dados',
            ], 500);
        }
    }

    public function user($id)
    {
        try {
            $user = User::where('id', $id)
                ->get();

            return response()->json([
                'data' => $user,
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
            $user = User::find($id);
            $user->update($data);

            //return $sponsor->toJson();
            return response()->json([
                'data' => $user,
            ], 200);
        }else {
            return response()->json([
                'fail' => true,
                'info' => 'Verifique os dados do usuário. (id)'
            ]);
        }
    }

    public function del($id)
    {
        $user = User::find($id);

        $user->delete();
        return response()->json(['success' => true]);
    }
}
