<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Traits\ResfulResourceTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterLeaveFormRequest extends FormRequest
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
        return [
            'request_type' => 'required|numeric|in:2,3',
            'leave_all_day' => 'nullable|numeric|in:0,1',
            'leave_start' => 'nullable|date_format:H:i',
            'leave_end' => 'nullable|date_format:H:i|after:leave_start',
            'reason'  => 'required',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException($this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
