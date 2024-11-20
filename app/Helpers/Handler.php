<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            throw new ApiException(
                message: 'Resource not found',
                code: 404
            );
        }

        return parent::render($request, $e);
    }
}
