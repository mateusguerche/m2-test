<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDiscountRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'type' => [
                'required',
                'string',
                Rule::in(\App\Models\Discount::TYPE)
            ],
        ];
    }

    /**
     * Faz com que a validação do campo seja executada.
     *
     * @return Illuminate\Foundation\Http\FormRequest
     */
    public function getValidatorInstance()
    {
        $this->formatAmount();

        return parent::getValidatorInstance();
    }

    /**
     * Transforma a string da request ['amount'] em float/decimal
     *
     * @return float
     */
    protected function formatAmount()
    {
        if ($this->request->has('amount')) {
            $this->merge([
                'amount' => floatval(str_replace(',', '.', str_replace('.', '', $this->request->get('amount'))))
            ]);
        }
    }
}
