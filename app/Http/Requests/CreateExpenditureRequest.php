<?php

namespace App\Http\Requests;

use App\Rules\CheckDate;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Carbon;

class CreateExpenditureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description'   => 'required|string|max:191',
            'datetime'          => ['required', 'date', new CheckDate($this)],
            'user_id'       => 'required|exists:users,id',
            'amount'        => 'required|min:0',
        ];
    }

}
