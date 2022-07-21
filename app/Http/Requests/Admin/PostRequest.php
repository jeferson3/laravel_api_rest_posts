<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\RequestValidation;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PostRequest extends RequestValidation
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
            'title'         => 'required',
            'description'   => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'title'         => 'título',
            'description'   => 'descrição'
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'O campo :attribute é obrigatório!'
        ];
    }

}
