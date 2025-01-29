<?php

namespace App\Http\Requests;

use App\Models\Prize;
use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $currentPrize = Prize::find($this->route('prize'));
        $currentTotal = Prize::sum('probability');
        
        if ($currentPrize) {
            $currentTotal -= $currentPrize->probability;
        }
        
        $maxAllowed = 100 - $currentTotal;
        
        return [
            'title' => 'required|string|max:255',
            'probability' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $maxAllowed,
            ]
        ];
    }
    
    public function messages()
    {
        return [
            'probability.max' => 'The total probability cannot exceed 100%. Maximum allowed is :max%'
        ];
    }
}
