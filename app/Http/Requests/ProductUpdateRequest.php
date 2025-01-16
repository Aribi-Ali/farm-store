<?php

namespace App\Http\Requests;

use App\Rules\ValidCategoryAttribute;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // adding update request rules

        return [
            // here we are adding the update request rules
            'SKU' => 'required|string|unique:products,SKU,' . $this->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'newPrice' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'isActive' => 'boolean',
            'store_id' => 'required|exists:stores,id',
            'hasCustomShipping' => 'boolean',
            'homeCustomShipping_cost' => 'nullable|numeric|min:0',
            'stopDeskCustomShipping_cost' => 'nullable|numeric|min:0',
            'freeShipping' => 'boolean',
            'specialPrice' => 'nullable|numeric|min:0',
            'specialPriceStartDate' => 'required_if:specialPrice,!=,null|date',
            'specialPriceEndDate' => 'required_if:specialPrice,!=,null|date',
            'metadata' => 'nullable|json',
            'tags' => 'nullable|array|exists:tags,id',
            'brand' => 'nullable|exists:brands,id',
            'attributes.*.id' => [
                'required',
                'exists:attributes,id',
                new ValidCategoryAttribute($this->category_id),
            ],
            'options' => ['nullable', 'array'], // Optional options
            'options.*' => ['exists:attribute_options,id'],

        ];
    }
}
