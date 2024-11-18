<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class GetAllTasksRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_from' => ['sometimes', 'date' ,'before_or_equal:date_to'],
            'date_to' => ['sometimes', 'date','after_or_equal:date_from'],
            'status' => ['sometimes', 'string', 'in:' . implode(',', TaskStatusEnum::values())],
        ];
    }
}
