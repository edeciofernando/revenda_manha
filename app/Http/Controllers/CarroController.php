<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carro;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carros = Carro::all();
        
        return view('carros_list', compact('carros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // indica inclusão
        $acao = 1;
        
        return view('carros_form', compact('acao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // recupera todos os campos do formulário
        $dados = $request->all();
        
        // insere os dados na tabela
        $car = Carro::create($dados);
        
        if ($car) {
            return redirect()->route('carros.index')
                    ->with('status', $request->modelo.' Incluído!');            
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
        // obtém os dados do registro a ser editado 
        $reg = Carro::find($id);
        
        // indica ao form que será alteração
        $acao = 2;
        
        return view('carros_form', compact('reg', 'acao'));        
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
        $reg = Carro::find($id);
        
        $dados = $request->all();
        
        $alt = $reg->update($dados);
        
        if ($alt) {
            return redirect()->route('carros.index')
                    ->with('status', $request->modelo.' Alterado!');                        
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
}
