<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResponseHandler
{
    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public static function success(string $message, array|object|string $data = [], array $paginationAttributes = [])
    {
        if (
            gettype($data) === 'object' &&
            get_class($data) === 'Illuminate\Http\Resources\Json\AnonymousResourceCollection'
        ) {
            return $data->additional([
                ...$paginationAttributes,
                'code' => 200,
                'message' => $message,
                'errors' => (object) [],
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' => self::previewData($data),
            'errors' => (object) [],
        ], 200);
    }

    /**
     * @return JsonResponse
     */
    public static function validationError(array $errors)
    {
        $data = [
            'code' => 422,
            'message' => __('There was an error with your input. Please try again.'),
            'errors' => $errors,
            'data' => (object) [],
        ];

        return response()->json($data, 422);
    }

    /**
     * @return array|mixed|object
     */
    private static function previewData($data)
    {
        if (is_array($data)) {
            return count($data) ? $data : (object) [];
        }

        return $data;
    }
}
