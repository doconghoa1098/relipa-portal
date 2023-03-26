<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResfulResourceTrait;

class AuthPostRequest extends FormRequest
{
    use ResfulResourceTrait;
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
        if ($this->method() == "POST") {

            return [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
