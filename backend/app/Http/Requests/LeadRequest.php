<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'departure_id' => ['required', 'exists:departures,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'passengers_count' => ['required', 'integer', 'min:1', 'max:10'],
            'room_type_requested' => ['required', 'string', 'in:quadruple,triple,double,single'],
            'estimated_total_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'status' => ['sometimes', 'string', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
