<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateCampaignRequest;
use App\Http\Requests\Api\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\CityGroup;
use App\Models\Discount;
use App\Models\Product;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    use ApiResponser;

    /**
     * Exibe todas as Campanhas.
     *
     * @return ApiResponser
     */
    public function index()
    {
        $campaigns = Campaign::with('cityGroup', 'products', 'discount')->get();

        return $this->success($campaigns);
    }

    /**
     * Exibe uma Campanha.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function show($id)
    {
        $campaign = Campaign::with('cityGroup', 'products', 'discount')->where(['id' => $id])->first();

        /* Verifica se a campanha existe */
        if (!$campaign) {
            return $this->error('Campanha não encontrada.', 404);
        }

        return $this->success($campaign);
    }

    /**
     * Cadastra uma nova Campanha.
     *
     * @param  CreateCampaignRequest $request
     * @return ApiResponser
     */
    public function store(CreateCampaignRequest $request)
    {
        DB::beginTransaction();
        try {
            $cityGroup = CityGroup::where(['id' => $request->city_group_id])->first();

            /* Verifica se o grupo existe */
            if (!$cityGroup) {
                return $this->error('Grupo não encontrado.', 404);
            }

            $verifyCampaign = Campaign::where(['city_group_id' => $request->city_group_id, 'status' => true])->first();

            /* Verifica se o Grupo ja tem uma Campanha ativa */
            if ($verifyCampaign) {
                return $this->error('O Grupo ja tem uma campanha ativa.', 404);
            }

            $discount = Discount::where(['id' => $request->discount_id])->first();

            /* Verifica se o desconto existe */
            if (!$discount && $request->discount_id != null) {
                return $this->error('Desconto não encontrado.', 404);
            }

            $payload = [
                'name' => $request->name,
                'city_group_id' => $request->city_group_id,
                'discount_id' => $request->discount_id
            ];

            $campaign = Campaign::create($payload);

            foreach ($request->campaign_products as $campaign_product) {

                $verifyProduct = Product::where(['id' =>  $campaign_product['product_id']])->first();

                /* Verifica se o produto existe */
                if (!$verifyProduct) {
                    return $this->error('Produto não encontrado.', 404);
                }

                $campaignProductPayload = [
                    'campaign_id' =>  $campaign->id,
                    'product_id' => $campaign_product['product_id']
                ];

                CampaignProduct::create($campaignProductPayload);
            }
            $campaign = Campaign::with('cityGroup', 'products', 'discount')->where(['id' => $campaign->id])->first();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro no cadastro da campanha.', 400);
        }
        DB::commit();
        return $this->success($campaign, 'Campanha cadastrada com sucesso.', 200);
    }

    /**
     * Edita uma Campanha
     *
     * @param  UpdateCampaignRequest $request
     * @param  int $id
     * @return ApiResponser
     */
    public function update(UpdateCampaignRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $campaign = Campaign::with('cityGroup', 'products', 'discount')->where(['id' => $id])->first();

            /* Verifica se a campanha existe */
            if (!$campaign) {
                return $this->error('Campanha não encontrada.', 404);
            }

            /* Verifica se o status enviado é para ativar ou manter ativada a campanha */
            if ($request->status == true) {
                $verifyCampaign = Campaign::where(['city_group_id' => $request->city_group_id, 'status' => true])->whereNotIn('id', array($campaign->id))->first();

                /* Verifica se o Grupo ja tem uma Campanha ativa */
                if ($verifyCampaign) {
                    return $this->error('O Grupo ja tem uma campanha ativa.', 404);
                }
            }

            $discount = Discount::where(['id' => $request->discount_id])->first();

            /* Verifica se o desconto existe */
            if (!$discount && $request->discount_id != null) {
                return $this->error('Desconto não encontrado.', 404);
            }

            $payload = [
                'name' => $request->name,
                'city_group_id' => $request->city_group_id,
                'discount_id' => $request->discount_id,
                'status' => $request->status
            ];

            $campaign->update($payload);

            CampaignProduct::where(['campaign_id' => $campaign->id])->delete();

            foreach ($request->campaign_products as $campaign_product) {

                $verifyProduct = Product::where(['id' =>  $campaign_product['product_id']])->first();

                /* Verifica se o produto existe */
                if (!$verifyProduct) {
                    return $this->error('Produto não encontrado.', 404);
                }

                $campaignProductPayload = [
                    'campaign_id' =>  $campaign->id,
                    'product_id' => $campaign_product['product_id']
                ];

                CampaignProduct::create($campaignProductPayload);
            }

            $campaign = Campaign::with('cityGroup', 'products',  'discount')->where(['id' => $campaign->id])->first();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na edição da campanha.', 400);
        }
        DB::commit();
        return $this->success($campaign, 'Campanha editada com sucesso.', 200);
    }

    /**
     * Exclui uma Campanha.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $campaign = Campaign::with('cityGroup', 'products',  'discount')->where(['id' => $id])->first();

            CampaignProduct::where(['campaign_id' => $campaign->id])->delete();

            $campaign->delete();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na exclusão da campanha.', 400);
        }
        DB::commit();
        return $this->success($campaign, 'Campanha excluida com sucesso.', 200);
    }
}
