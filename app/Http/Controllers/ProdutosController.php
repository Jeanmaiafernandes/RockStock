<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produtos\ProdutosStoreRequest;
use App\Http\Requests\Produtos\ProdutosUpdateRequest;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
use App\Models\ProdutoTamanho;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProdutosController extends Controller
{
    public function index(Request $request): View
    {
        $consulta = Produto::query()
            ->with(['categoria', 'fornecedor', 'status'])
            ->withCount('variacoes');

        if ($request->filled('busca')) {
            $busca = $request->input('busca');

            $consulta->where(function ($query) use ($busca) {
                $query->where('referencia', 'like', "%{$busca}%")
                    ->orWhere('nome', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('categoria')) {
            $consulta->where('produto_categoria_id', $request->input('categoria'));
        }

        if ($request->filled('fornecedor')) {
            $consulta->where('fornecedor_id', $request->input('fornecedor'));
        }

        if ($request->filled('status')) {
            $consulta->where('produto_status_id', $request->input('status'));
        }

        // withQueryString() mantém os filtros ao trocar de página
        $produtos = $consulta->orderBy('referencia')->paginate(15)->withQueryString();

        return view('produtos.index', [
            'produtos'     => $produtos,
            'categorias'   => ProdutoCategoria::orderBy('nome')->pluck('nome', 'id'),
            'fornecedores' => Fornecedor::orderBy('nome')->pluck('nome', 'id'),
            'status'       => ProdutoStatus::orderBy('nome')->pluck('nome', 'id'),
        ]);
    }

    public function create(): View
    {
        return view('produtos.criar', [
            'categorias'   => ProdutoCategoria::orderBy('nome')->pluck('nome', 'id'),
            'fornecedores' => Fornecedor::orderBy('nome')->pluck('nome', 'id'),
            'status'       => ProdutoStatus::orderBy('nome')->pluck('nome', 'id'),
            'tamanhos'     => ProdutoTamanho::orderBy('ordem')->get(),
        ]);
    }

    public function store(ProdutosStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $produto = DB::transaction(function () use ($dados) {
            $produto = new Produto();
            $produto->referencia = $dados['referencia'];
            $produto->nome = $dados['nome'];
            $produto->colecao = $dados['colecao'] ?? null;
            $produto->descricao = $dados['descricao'] ?? null;
            $produto->fornecedor_id = $dados['fornecedor_id'];
            $produto->produto_categoria_id = $dados['produto_categoria_id'];
            $produto->produto_status_id = $dados['produto_status_id'];
            $produto->save();

            if (! empty($dados['cores']) && ! empty($dados['tamanhos'])) {
                $produto->gerarGrade($dados['cores'], $dados['tamanhos']);
            }

            return $produto;
        });

        return redirect()->route('produtos.show', $produto)
            ->with('sucesso', "Produto {$produto->referencia} cadastrado.");
    }

    public function show(Produto $produto): View
    {
        $produto->load(['categoria', 'fornecedor', 'status', 'variacoes.tamanho']);

        return view('produtos.visualizar', [
            'produto'  => $produto,
            'tamanhos' => ProdutoTamanho::orderBy('ordem')->get(),
        ]);
    }

    public function edit(Produto $produto): View
    {
        return view('produtos.editar', [
            'produto'      => $produto,
            'categorias'   => ProdutoCategoria::orderBy('nome')->pluck('nome', 'id'),
            'fornecedores' => Fornecedor::orderBy('nome')->pluck('nome', 'id'),
            'status'       => ProdutoStatus::orderBy('nome')->pluck('nome', 'id'),
        ]);
    }

    public function update(ProdutosUpdateRequest $request, Produto $produto): RedirectResponse
    {
        $dados = $request->validated();

        // A referência não muda: os SKUs foram montados a partir dela
        $produto->nome = $dados['nome'];
        $produto->colecao = $dados['colecao'] ?? null;
        $produto->descricao = $dados['descricao'] ?? null;
        $produto->fornecedor_id = $dados['fornecedor_id'];
        $produto->produto_categoria_id = $dados['produto_categoria_id'];
        $produto->produto_status_id = $dados['produto_status_id'];
        $produto->save();

        return redirect()->route('produtos.show', $produto)
            ->with('sucesso', "Produto {$produto->referencia} atualizado.");
    }
}
