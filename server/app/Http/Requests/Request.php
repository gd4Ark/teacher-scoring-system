<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Urameshibr\Requests\FormRequest;


class Request extends FormRequest
{
    use ApiResponse;

    protected $status_code = 422;
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
        return [];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return $this->failed(array_values($errors)[0][0], $this->status_code);
    }

    /**
     * @param string|null $param
     * @return mixed
     */
    public function routeParam(string $param = null){
        return $param ? $this->route()[2][$param] : $this->route()[2];
    }
}
