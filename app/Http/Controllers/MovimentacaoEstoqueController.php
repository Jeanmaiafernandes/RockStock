<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoEstoque;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovimentacaoEstoqueController extends Controller
{
    public function index(): View
    {
        $movimentacoes = MovimentacaoEstoque::with([
            'produto:id,sku,nome',
            'usuario:id,nome',
            'enderecoOrigem:id,codigo',
            'enderecoDestino:id,codigo',
        ])
            ->latest()
            ->paginate(15);

        return view('movimentacoes.index', compact('movimentacoes'));
    }

    public function show(MovimentacaoEstoque $movimentacaoEstoque)
    {

    }

}
