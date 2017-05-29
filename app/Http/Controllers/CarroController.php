<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Carro;
use App\Marca;
use App\Mail\AvisoPromocao;

class CarroController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect('/');
        }
//        $carros = Carro::all();        
        $carros = Carro::paginate(3);
        return view('carros_list', compact('carros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect('/');
        }
        // indica inclusão
        $acao = 1;

        // obtém as marcas para exibir no form de cadastro
        $marcas = Marca::orderBy('nome')->get();

        return view('carros_form', compact('acao', 'marcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'modelo' => 'required|unique:carros|min:2|max:60',
            'cor' => 'required|min:4|max:40',
            'ano' => 'required|numeric|min:1970|max:2020',
            'preco' => 'required'
        ]);

        // recupera todos os campos do formulário
        $dados = $request->all();

        // insere os dados na tabela
        $car = Carro::create($dados);

        if ($car) {
            return redirect()->route('carros.index')
                            ->with('status', $request->modelo . ' Incluído!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        // se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect('/');
        }
        // obtém os dados do registro a ser editado 
        $reg = Carro::find($id);

        // obtém as marcas para exibir no form de cadastro
        $marcas = Marca::orderBy('nome')->get();

        // indica ao form que será alteração
        $acao = 2;

        return view('carros_form', compact('reg', 'acao', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'modelo' => ['required', 'unique:carros,modelo,' . $id, 'min:2', 'max:60'],
            'cor' => 'required|min:4|max:40',
            'ano' => 'required|numeric|min:1970|max:2020',
            'preco' => 'required'
        ]);

        $reg = Carro::find($id);

        $dados = $request->all();

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('carros.index')
                            ->with('status', $request->modelo . ' Alterado!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $carro = Carro::find($id);
        if ($carro->delete()) {
            return redirect()->route('carros.index')
                            ->with('status', $carro->modelo . ' Excluído!');
        }
    }

    public function foto($id) {
        // se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect('/');
        }
        // obtém os dados do registro a ser exibido
        $reg = Carro::find($id);

        // obtém as marcas para exibir no form de cadastro
        $marcas = Marca::orderBy('nome')->get();

        return view('carros_foto', compact('reg', 'marcas'));
    }

    public function storefoto(Request $request) {

        // recupera todos os campos do formulário
        $dados = $request->all();

        $id = $dados['id'];

        if (isset($dados['foto'])) {
            $fotoId = $id . '.jpg';
            $request->foto->move(public_path('fotos'), $fotoId);
        }

        return redirect()->route('carros.index')
                        ->with('status', $request->modelo . ' com Foto Cadastrada!');
    }

    public function pesq() {
        // se não estiver autenticado, redireciona para login
        if (!Auth::check()) {
            return redirect('/');
        }
        $carros = Carro::paginate(3);
        return view('carros_pesq', compact('carros'));
    }

    public function filtro(Request $request) {
        // obtém dados do form de pesquisa
        $modelo = $request->modelo;
        $precomax = $request->precomax;

        $cond = array();

        if (!empty($modelo)) {
            array_push($cond, array('modelo', 'like', '%' . $modelo . '%'));
        }

        if (!empty($precomax)) {
            array_push($cond, array('preco', '<=', $precomax));
        }

        $carros = Carro::where($cond)
                        ->orderBy('modelo')->paginate(3);
        return view('carros_pesq', compact('carros'));
    }

    public function filtro2(Request $request) {
        // obtém dados do form de pesquisa
        $modelo = $request->modelo;
        $precomax = $request->precomax;

        if (empty($precomax)) {
            $carros = Carro::where('modelo', 'like', '%' . $modelo . '%')
                            ->orderBy('modelo')->paginate(3);
        } else {
            $carros = Carro::where('modelo', 'like', '%' . $modelo . '%')
                            ->where('preco', '<=', $precomax)
                            ->orderBy('modelo')->paginate(3);
        }
        return view('carros_pesq', compact('carros'));
    }

    public function graf() {
        $carros = DB::table('carros')
                ->join('marcas', 'carros.marca_id', '=', 'marcas.id')
                ->select('marcas.nome as marca', DB::raw('count(*) as num'))
                ->groupBy('marcas.nome')
                ->get();

        return view('carros_graf', compact('carros'));
    }

    public function enviacontato() {
        $destino = "edeciofernando@gmail.com";
        Mail::to($destino)->send(new AvisoPromocao());
    }
    
}
