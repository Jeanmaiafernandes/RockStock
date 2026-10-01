<?php

namespace App\Http\Controllers\Produto;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produtos\ProdutosVariacoesStoreRequest;
use App\Http\Requests\Produtos\ProdutosVariacoesUpdateRequest;
use App\Models\Produto\Produto;
use App\Models\Produto\ProdutoVariacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ProdutosVariacoesController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function salvar(ProdutosVariacoesStoreRequest $request, Produto $produto): RedirectResponse
    {
        $dados = $request->validated();

        $criadas = DB::transaction(function () use ($produto, $dados) {
            return $produto->gerarGrade($dados['cores'], $dados['tamanhos']);
        });

        if ($criadas === 0) {
            return redirect()->route('produtos.mostrar', $produto)
                ->with('aviso', 'Nenhum SKU novo: todas as combinações já existiam.');
        }

        return redirect()->route('produtos.mostrar', $produto)
            ->with('sucesso', "{$criadas} SKU(s) adicionado(s) à grade.");
    }

    public function atualizar(ProdutosVariacoesUpdateRequest $request, ProdutoVariacao $variacao): RedirectResponse
    {
        $dados = $request->validated();

        $variacao->ean = $dados['ean'];
        $variacao->ativo = $dados['ativo'];
        $variacao->save();

        return redirect()->route('produtos.mostrar', $variacao->produto_id)
            ->with('sucesso', "Variação {$variacao->sku} atualizada.");
    }
}
