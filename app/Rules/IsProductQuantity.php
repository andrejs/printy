<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class IsProductQuantity
 */
class IsProductQuantity implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $item) {
            if (count($item) !== 2 || empty($item['product_id']) || empty('quantity')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Data malformed, product id or quantity is not present or is invalid.';
    }
}
