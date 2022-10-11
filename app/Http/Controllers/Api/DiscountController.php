<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateDiscountRequest;
use App\Http\Requests\Api\UpdateDiscountRequest;
use App\Models\Campaign;
use App\Models\Discount;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    use ApiResponser;

    /**
     * Exibe todos os descontos.
     *
     * @return ApiResponser
     */
    public function index()
    {
        $discounts = Discount::with('campaign')->get();

        return $this->success($discounts);
    }

    /**
     * Exibe um desconto.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function show($id)
    {
        $discount = Discount::with('campaign')->where(['id' => $id])->first();

        /* Verifica se o desconto existe */
        if (!$discount) {
            return $this->error('Desconto não encontrado.', 404);
        }

        return $this->success($discount);
    }

    /**
     * Cadastra um novo Desconto.
     *
     * @param  CreateDiscountRequest $request
     * @return ApiResponser
     */
    public function store(CreateDiscountRequest $request)
    {
        DB::beginTransaction();
        try {

            if ($request->type == 'percentage') {
                if ($request->amount > 100) {
                    return $this->error('Não é possivel criar um desconto com mais de 100%.', 404);
                }
            }

            $payload = [
                'amount' => $request->amount,
                'type' => $request->type,
            ];

            $discount = Discount::create($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro no cadastro do desconto.', 400);
        }
        DB::commit();
        return $this->success($discount, 'Desconto cadastrado com sucesso.', 200);
    }

    /**
     * Edita um Desconto.
     *
     * @param  UpdateDiscountRequest $request
     * @param  int $id
     * @return ApiResponser
     */
    public function update(UpdateDiscountRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $discount = Discount::with('campaign')->where(['id' => $id])->first();

            /* Verifica se o desconto existe */
            if (!$discount) {
                return $this->error('Desconto não encontrado.', 404);
            }

            if ($request->type == 'percentage') {
                if ($request->amount > 100) {
                    return $this->error('Não é possivel criar um desconto com mais de 100%.', 404);
                }
            }

            $payload = [
                'amount' => $request->amount,
                'type' => $request->type,
            ];

            $discount->update($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na edição do desconto.', 400);
        }
        DB::commit();
        return $this->success($discount, 'Desconto editado com sucesso.', 200);
    }

    /**
     * Exclui um Desconto.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $discount = Discount::with('campaign')->where(['id' => $id])->first();

            /* Verifica se o desconto existe */
            if (!$discount) {
                return $this->error('Desconto não encontrado.', 404);
            }

            $campaign = Campaign::where(['discount_id' => $discount->id])->first();

            /* Verifica se o desconto está vinculado a uma campanha */
            if ($campaign) {
                return $this->error('Desconto vinculado a uma campanha.', 404);
            }

            $discount->delete();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na exclusão do desconto', 400);
        }
        DB::commit();
        return $this->success($discount, 'Desconto excluido com sucesso.', 200);
    }
}
