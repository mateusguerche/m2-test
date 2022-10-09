<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'value' => 'required|numeric',
        ];
    }

    /**
     * Faz com que a validação do campo seja executada.
     *
     * @return Illuminate\Foundation\Http\FormRequest
     */
    public function getValidatorInstance()
    {
        $this->formatValue();

        return parent::getValidatorInstance();
    }

    /**
     * Transforma a string da request ['value'] em float/decimal
     *
     * @return float
     */
    protected function formatValue()
    {
        if ($this->request->has('value')) {
            $this->merge([
                'value' => floatval(str_replace(',', '.', str_replace('.', '', $this->request->get('value'))))
            ]);
        }
    }
}
