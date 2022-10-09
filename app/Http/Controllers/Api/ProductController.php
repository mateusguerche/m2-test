<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ApiResponser;

    /**
     * Exibi todos os produtos.
     *
     * @return ApiResponser
     */
    public function index()
    {
        $products = Product::get();

        return $this->success($products);
    }

    /**
     * Exibi um produto.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function show($id)
    {
        $products = Product::where(['id' => $id])->first();

        /* Verifica se o produto existe */
        if (!$products) {
            return $this->error('Produto não encontrado.', 404);
        }

        return $this->success($products);
    }

    /**
     * Cadastra um novo Produto.
     *
     * @param  CreateProductRequest $request
     * @return ApiResponser
     */
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try {

            $payload = [
                'name' => $request->name,
                'value' => $request->value,
            ];

            $product = Product::create($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro no cadastro do produto.', 400);
        }
        DB::commit();
        return $this->success($product, 'Produto cadastrado com sucesso.', 200);
    }

    /**
     * Edita um Produto.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     * @return ApiResponser
     */
    public function edit(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::where(['id' => $id])->first();

            /* Verifica se o produto existe */
            if (!$product) {
                return $this->error('Produto não encontrado.', 404);
            }

            $payload = [
                'name' => $request->name,
                'value' => $request->value,
            ];

            $product->update($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na edição do produto.', 400);
        }
        DB::commit();
        return $this->success($product, 'Produto editado com sucesso.', 200);
    }

    /**
     * Exclui um Produto.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::where(['id' => $id])->first();

            /* Verifica se o produto existe */
            if (!$product) {
                return $this->error('Produto não encontrado.', 404);
            }

            $product->delete();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na exclusão do produto', 400);
        }
        DB::commit();
        return $this->success($product, 'Produto excluido com sucesso.', 200);
    }
}
