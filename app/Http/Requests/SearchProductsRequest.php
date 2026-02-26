<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q'         => ['nullable', 'string', 'max:100'],
            'category'  => ['nullable', 'string', 'max:100'],
            'tag'       => ['nullable', 'string', 'max:100'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price_min'],
            'sort'      => ['nullable', 'in:newest,price_asc,price_desc,name_asc'],
            'page'      => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Return only the relevant, validated filter values.
     */
    public function filters(): array
    {
        return $this->validated();
    }
}
