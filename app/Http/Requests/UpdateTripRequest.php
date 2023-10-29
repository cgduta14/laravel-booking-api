<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
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

        return [
            'title' => 'sometimes|required',
            'slug' => 'sometimes|required|unique:trips',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string',
            'price' => 'sometimes|required|decimal:2'
        ];
    }
}
