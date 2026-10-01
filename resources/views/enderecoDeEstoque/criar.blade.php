@extends('layouts.app')

@section('titulo', 'Novo endereço de estoque')

@section('conteudo')

    <x-page-header title="Novo endereço de estoque" />

    @include('enderecoDeEstoque.partials._form')

@endsection
