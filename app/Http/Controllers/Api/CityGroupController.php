<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateCityGroupRequest;
use App\Http\Requests\Api\UpdateCityGroupRequest;
use App\Models\City;
use App\Models\CityGroup;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CityGroupController extends Controller
{
    use ApiResponser;

    /**
     * Exibi todos os Grupo de Cidades.
     *
     * @return ApiResponser
     */
    public function index()
    {
        $cityGroups = CityGroup::with('city')->get();

        return $this->success($cityGroups);
    }

    /**
     * Exibi um Grupo de Cidades.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function show($id)
    {
        $cityGroup = CityGroup::with('city')->where(['id' => $id])->first();

        /* Verifica se o grupo existe */
        if (!$cityGroup) {
            return $this->error('Grupo não encontrado.', 404);
        }

        return $this->success($cityGroup);
    }

    /**
     * Cadastra um novo Grupo de Cidades.
     *
     * @param  CreateCityGroupRequest $request
     * @return ApiResponser
     */
    public function store(CreateCityGroupRequest $request)
    {
        DB::beginTransaction();
        try {

            /* Determina o slug do nome enviado */
            $slug = Str::slug($request->name, '-');

            $verifyCityGroup = CityGroup::where(['slug' => $slug])->first();

            /* Verifica se o nome já existe */
            if ($verifyCityGroup) {
                return $this->error('Nome de grupo já existe.', 400);
            }

            $payload = [
                'name' => $request->name,
                'slug' => $slug
            ];

            $cityGroup = CityGroup::create($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro no cadastro do grupo.', 400);
        }
        DB::commit();
        return $this->success($cityGroup, 'Grupo cadastrado com sucesso.', 200);
    }

    /**
     * Edita um Grupo de Cidades.
     *
     * @param  UpdateCityGroupRequest $request
     * @param  int $id
     * @return ApiResponser
     */
    public function update(UpdateCityGroupRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            /* Determina o slug do nome enviado */
            $slug = Str::slug($request->name, '-');

            $verifyCityGroup = CityGroup::where(['slug' => $slug])->first();

            /* Verifica se o nome já existe */
            if ($verifyCityGroup) {
                return $this->error('Nome do grupo já existe.', 400);
            }

            $cityGroup = CityGroup::where(['id' => $id])->first();

            /* Verifica se o grupo existe */
            if (!$cityGroup) {
                return $this->error('Grupo não encontrado.', 404);
            }

            $payload = [
                'name' => $request->name,
                'slug' => $slug
            ];

            $cityGroup->update($payload);
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na edição do grupo.', 400);
        }
        DB::commit();
        return $this->success($cityGroup, 'Grupo editado com sucesso.', 200);
    }

    /**
     * Exclui um Grupo de Cidades.
     *
     * @param  int $id
     * @return ApiResponser
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $cityGroup = CityGroup::where(['id' => $id])->first();

            /* Verifica se o grupo existe */
            if (!$cityGroup) {
                return $this->error('Grupo não encontrado.', 404);
            }

            $cities = City::where(['city_group_id' => $id])->get();

            /* Verifica se existe cidades que pertence a este grupo */
            if (!empty($cities->toArray())) {
                return $this->error('Grupo possui cidades relacionadas.', 404);
            }

            $cityGroup->delete();
        } catch (CustomException $e) {
            DB::rollback();
            return $this->error($e->render(), 400);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->error('Erro na exclusão do grupo.', 400);
        }
        DB::commit();
        return $this->success($cityGroup, 'Grupo excluido com sucesso.', 200);
    }
}
