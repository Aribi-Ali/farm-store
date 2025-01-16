<?php

namespace App\Rules;

use App\Models\Attribute;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCategoryAttribute implements ValidationRule
{

    protected $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $attribute= Attribute::where('id', $value)
            ->where('category_id', $this->categoryId)
            ->exists();
        if (!$attribute) {
            $fail($attribute . ' is not a valid attribute for this category');
        }
        }
}
