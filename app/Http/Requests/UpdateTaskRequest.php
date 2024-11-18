<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string','min:3','max:255'],
            'description' => ['string','min:3','max:255'],
            'due_date' => ['date_format:Y-m-d', 'after_or_equal:today'],
        ];
    }
}
