<?php

namespace App\Rules;

use Carbon\Carbon;
use Faker\Provider\Lorem;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckDate implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Carbon::parse($this->request->datetime) <= Carbon::parse(Carbon::now()))
            return true;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "A data não pode ser maior que hoje!";
    }
}