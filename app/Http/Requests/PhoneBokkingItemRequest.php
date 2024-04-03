<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneBokkingItemRequest extends FormRequest
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
        return [
            'first_name' => 'required',
            'last_name' => 'nullable|string',
            'phone_number' => 'required|regex:/^\+\d{2}\s\d{3}\d{3}\d{3}$/',
            'country_code' => 'required|string|in:US,CA,UK', // Example country codes
            'timezone' => 'required|string|in:America/New_York,America/Los_Angeles,Europe/London', // Example timezones
            'insertedOn' => 'required|date',
            'updatedOn' => 'required|date',
        ];
    }
}
