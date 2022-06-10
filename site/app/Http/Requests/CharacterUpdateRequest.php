<?php

namespace App\Http\Requests;

use App\Models\Dictionaries\CharacterNationDictionary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterUpdateRequest extends FormRequest
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
            'Name' => 'required|string|max:10',
            'LEV' => 'required|int|max:190',
            'STR' => 'required|int|max:9999',
            'DEX' => 'required|int|max:9999',
            'INT' => 'required|int|max:9999',
            'Alz' => 'required|int|max:999999999999',
            'Nation' => ['required', Rule::in(CharacterNationDictionary::getRange())],
        ];
    }
}
