<?php

namespace App\Http\Requests;

use App\Rules\CheckDate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditExpenditureRequest extends FormRequest
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
            'id'            => 'required|exists:expenditures,id',
            'description'   => 'required|string|max:191',
            'date'          => ['required', 'date', new CheckDate($this)],
            'user_id'       => 'required|exists:users,id',
            'amount'        => 'required|min:0',
        ];
    }
}
