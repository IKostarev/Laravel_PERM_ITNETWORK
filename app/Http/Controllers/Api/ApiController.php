<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * Успешный ответ
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithSuccess(array $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        if ($data) {
            return response()->json(['data' => $data], $code);
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Ошибочный ответ
     *
     * @param string $message
     * @param array $errors
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithError(string $message, array $errors = [], int $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
