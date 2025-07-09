<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DictiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $baseRules = [
            "full_name" => "nullable|string",
            "parent_id" => "nullable|int", 
            "char_value" => "nullable|string",
            "num_value" => "nullable|float", 
            "json_value" => "nullable|json",
            "constant" => "nullable|string",
            "constant1" => "nullable|string",
            "constant2" => "nullable|string",
        ];
        if ($this->isMethod("post")) {
            $baseRules["full_name" ] = "required|string";
        }
        return $baseRules;
    }
}
