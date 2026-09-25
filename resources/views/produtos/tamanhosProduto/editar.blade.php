@extends('layouts.app')

@section('titulo', 'Editar tamanho')

@section('conteudo')

    <x-page-header title="Editar tamanho {{ $tamanho->nome }}" />

    @include('produtos.tamanhosProduto.partials._form', ['tamanho' => $tamanho])

@endsection
