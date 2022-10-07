<?php

namespace App\Traits;

trait ApiResponser
{
    /**
     * Retorna uma resposta de sucesso.
     */
    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Retorna uma resposta de erro.
     */
    protected function error(string $message = null, int $code, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
