<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateCityRequest;
use App\Http\Requests\Api\UpdateCityRequest;
use App\Models\City;
use App\Models\CityGroup;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    use ApiResponser;

    /**
     * Exibi todos as Cidades.
     *
     * @return ApiResponser
     */
    public function index()
    {
        $cities = City::with('cityGroup')->get();

        return $this->success($cities);
    }

    /**
     * Exibi uma Cidade.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function show($id)
    {
        $city = City::with('cityGroup')->where(['id' => $id])->first();

        /* Verifica se a cidade existe */
        if (!$city) {
            return $this->error('Cidade não encontrada.', 404);
        }

        return $this->success($city);
    }

    /**
     * Cadastra uma nova Cidade.
     *
     * @param  CreateCityRequest $request
     * @return ApiResponser
     */
    public function store(CreateCityRequest $request)
    {
        DB::beginTransaction();
        try {
            $cityGroup = CityGroup::where(['id' => $request->city_group_id])->first();

            /* Verifica se o grupo existe */
            if (!$cityGroup) {
                return $this->error('Grupo não encontrado.', 404);
            }

            $payload = [
                'name' => $request->name,
                'state' => $request->state,
                'city_group_id' => $request->city_group_id
            ];

            $city = City::create($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro no cadastro da cidade.', 400);
        }
        DB::commit();
        return $this->success($city, 'Cidade cadastrada com sucesso.', 200);
    }

    /**
     * Edita uma Cidade.
     *
     * @param  UpdateCityRequest $request
     * @param  int $id
     * @return ApiResponser
     */
    public function update(UpdateCityRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $cityGroup = CityGroup::where(['id' => $request->city_group_id])->first();

            /* Verifica se o grupo existe */
            if (!$cityGroup) {
                return $this->error('Grupo não encontrado.', 404);
            }

            $city = City::where(['id' => $id])->first();

            /* Verifica se a cidade existe */
            if (!$city) {
                return $this->error('Cidade não encontrada.', 404);
            }

            return $payload = [
                'name' => $request->name,
                'state' => $request->state,
                'city_group_id' => $request->city_group_id
            ];

            $city->update($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na edição da cidade.', 400);
        }
        DB::commit();
        return $this->success($cityGroup, 'Cidade editada com sucesso.', 200);
    }

    /**
     * Exclui uma Cidade.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $city = City::where(['id' => $id])->first();

            /* Verifica se o grupo existe */
            if (!$city) {
                return $this->error('Cidade não encontrada.', 404);
            }

            $city->delete();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na exclusão da cidade.', 400);
        }
        DB::commit();
        return $this->success($city, 'Cidade excluida com sucesso.', 200);
    }
}
