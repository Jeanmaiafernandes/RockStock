@extends('layouts.app')

@section('titulo', 'Editar endereço de estoque')

@section('conteudo')

    <x-page-header title="Editar endereço {{ $enderecoDeEstoque->codigo }}" />

    @include('enderecoDeEstoque.partials._form', ['enderecoDeEstoque' => $enderecoDeEstoque])

@endsection
