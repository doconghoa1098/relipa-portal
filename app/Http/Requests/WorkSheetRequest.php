<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Traits\ResfulResourceTrait;

class WorkSheetRequest extends FormRequest
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
            'end_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'month' => [
                'nullable',
                Rule::in(["This month", "Last month", "This year", "All"])
            ],
            'work_date' => [
                'nullable',
                Rule::in(["asc", "desc"])
            ],
            'perpage' => 'nullable|numeric'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException($this->errorResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
