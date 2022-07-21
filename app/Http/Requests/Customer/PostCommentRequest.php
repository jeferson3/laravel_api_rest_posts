<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\RequestValidation;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PostCommentRequest extends RequestValidation
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
            'comment'         => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'comment'         => 'comentário'
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'O campo :attribute é obrigatório!'
        ];
    }

}
