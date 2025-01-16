<?php

namespace App\Http\Requests;

use App\Rules\ValidCategoryAttribute;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
        return [
            'SKU' => 'required|string|unique:products,SKU',
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
            "tags" => "nullable|array|exists:tags,id",
            "brand" => "nullable|exists:brands,id",
            // add validation for product attributes and options

            'attributes' => 'nullable|array',
            'attributes.*.id' => [
                'required',
                'exists:attributes,id',
                new ValidCategoryAttribute($this->category_id),
            ],


            'attributes.*.options' => 'required|array',
            'attributes.*.options.*.option_id' => 'required|exists:attribute_options,id',
            'attributes.*.options.*.value' => 'required|string',
            'attributes.*.options.*.adjustmentPrice' => 'required|numeric',
            'options' => ['nullable', 'array'], // Optional options
            'options.*' => ['exists:attribute_options,id'],
            'attributes.*.options.*.quantityBasedPrice' => 'nullable|array',
            'attributes.*.options.*.quantityBasedPrice.*' => 'nullable|numeric',
            'product_attributes.*.options.*.quantityBasedPrice' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    // Ensure the keys are valid quantities
                    foreach ($value as $quantity => $price) {
                        // Ensure the quantity is numeric and greater than or equal to 1
                        if (!is_numeric($quantity) || $quantity < 1) {
                            $fail('The quantity must be a valid numeric value greater than or equal to 1.');
                        }

                        // Ensure the price is a valid numeric value
                        if (!is_numeric($price)) {
                            $fail('The price must be a valid numeric value.');
                        }
                    }
                }
            ],

        ];
    }
}