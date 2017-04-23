@extends('principal')

@section('conteudo')

<div class='col-sm-11'>
    <h2> Cadastro de Carros </h2>
</div>
<div class='col-sm-1'>
    <a href='{{route('carros.create')}}' class='btn btn-primary' 
       role='button'> Novo </a>
</div>

@if (session('status'))
<div class="col-sm-12">
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
</div>
@endif

<div class='col-sm-12'>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Modelo</th>
                <th>Cor</th>
                <th>Ano</th>
                <th>Preço R$</th>
                <th>Combustível</th>
                <th>Data Cad.</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carros as $carro) 
            <tr>
                <td> {{$carro->id}} </td>
                <td> {{$carro->modelo}} </td>
                <td> {{$carro->cor}} </td>
                <td> {{$carro->ano}} </td>
                <td style="text-align: right"> {{number_format($carro->preco, 2, ',', '.')}} &nbsp;&nbsp; </td>
                <td> {{$carro->combustivel}} </td>
                <td> {{date_format($carro->created_at, 'd/m/Y')}} </td>
                <td> <a href='{{route('carros.edit', $carro->id)}}'
                        class='btn btn-info' 
                        role='button'> Alterar </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>    
</div>

@endsection