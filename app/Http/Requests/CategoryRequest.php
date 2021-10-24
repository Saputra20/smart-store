<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Log;

class CategoryRequest extends FormRequest
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
        switch (request()->method()) {
            case 'POST':
                $rule = 'unique:categories';
                break;
            case 'PUT':
                $rule = 'unique:categories,name,'.$this->category->id;
                break;
        }

        return [
            'name' => ['required', $rule]
        ];
    }

    /**
     * TODO
     *  Return costume response validation
     * 
     * @return object
     */
    protected function failedValidation(Validator $validator)
    {
        return errorResponse("validation error", $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
