<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosStoreRequest;
use App\Http\Requests\ProdutosUpdateRequest;
use App\Models\EnderecoDeEstoque;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProdutosController extends Controller
{
    public function index(): View
    {
        $produtos = Produto::query()
            ->with(['categoria', 'status', 'fornecedor', 'enderecoDeEstoque'])
            ->select(['id', 'nome', 'descricao', 'tamanho',
                'quantidade', 'sku',
                'produto_categoria_id',
                'produto_status_id',
                'fornecedor_id',
                'endereco_de_estoque_id'])
            ->paginate(10);

        return view('produtos.index', compact('produtos'));
    }

    public function create(): View
    {
        return view('produtos.criar', [
            'categorias' => ProdutoCategoria::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'status'     => ProdutoStatus::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'fornecedores' => Fornecedor::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'enderecos_de_estoque' => EnderecoDeEstoque::query()->orderBy('codigo')
                ->pluck('codigo', 'id')->toArray(),
        ]);
    }

    public function store(ProdutosStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $produto = new Produto();
        $produto->nome = $dados['nome'];
        $produto->descricao = $dados['descricao'];
        $produto->sku  = $dados['sku'];
        $produto->quantidade = $dados['quantidade'];
        $produto->tamanho = $dados['tamanho'];
        $produto->produto_status_id = $dados['produto_status_id'];
        $produto->produto_categoria_id = $dados['produto_categoria_id'];
        $produto->fornecedor_id = $dados['fornecedor_id'];
        $produto->endereco_de_estoque_id = $dados ['endereco_de_estoque_id'];
        $produto->save();

        return redirect()->route('produtos.index')
            ->with('successo', 'Produto cadastrado com sucesso!');
    }

    public function show(Produto $produto): View
    {
        $produto->load(['categoria', 'Status']);

        return view('produtos.visualizar',
            compact('produto'));
    }

    public function edit(Produto $produto): View
    {
        return view('produtos.editar', [
            'produto'    => $produto,
            'categorias' => ProdutoCategoria::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'status'     => ProdutoStatus::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'fornecedores' => Fornecedor::query()->orderBy('nome')
                ->pluck('nome', 'id')->toArray(),
            'enderecos_de_estoque' => EnderecoDeEstoque::query()->orderBy('codigo')
                ->pluck('codigo', 'id')->toArray(),
        ]);
    }

    public function update(ProdutosUpdateRequest $request, Produto $produto): RedirectResponse
    {
        $dados = $request->validated();

        $produto->nome = $dados['nome'];
        $produto->descricao = $dados['descricao'];
        $produto->sku  = $dados['sku'];
        $produto->quantidade = $dados['quantidade'];
        $produto->tamanho = $dados['tamanho'];
        $produto->produto_status_id = $dados['produto_status_id'];
        $produto->produto_categoria_id = $dados['produto_categoria_id'];
        $produto->fornecedor_id = $dados['fornecedor_id'];
        $produto->endereco_de_estoque_id = $dados ['endereco_de_estoque_id'];
        $produto->update();

        return redirect()->route('produtos.index')
            ->with('status', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        if($produto->pedidosItens()->exists()) {
            return redirect()->route('produtos.index')
                ->with('erro', 'Não é possivel excluir: há pedidos vinculados');
        }

        $produto->delete();
        return redirect()->route('produtos.index')
            ->with('status', 'Produto removido com sucesso!');
    }
}
