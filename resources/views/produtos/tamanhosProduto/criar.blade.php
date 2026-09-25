@extends('layouts.app')

@section('titulo', 'Novo tamanho')

@section('conteudo')

    <x-page-header title="Novo tamanho" />

    @include('produtos.tamanhosProduto.partials._form')

@endsection
