<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    public $data = [];
    public $errors = [];

    public function __construct(string $message, $data = [], $code = 400, $errors = [])
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json([
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->previewData($this->data),
            'errors' => (object) $this->errors,
        ], $this->code);
    }

    /**
     * @return array|object
     */
    private function previewData($data)
    {
        if (is_array($data)) {
            return count($data) > 0 ? $data : (object) [];
        }

        return $data;
    }
}
