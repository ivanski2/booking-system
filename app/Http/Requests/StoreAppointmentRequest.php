<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'appointment_datetime' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $inputDate = Carbon::parse($value);
                    if ($inputDate->isPast()) {
                        $fail('Data and time must be in the future.');
                    }
                },
            ],
            'client_name' => 'required|string|min:3|max:100',
            'client_egn'  => 'required|digits:10', // 10 digits egn
            'description' => 'nullable|string|max:1000',
            'notification_type' => [
                'required',
                Rule::in(['SMS', 'Email']),
            ],
        ];
    }

    public function messages()
    {
        return [
            'appointment_datetime.required' => 'Please enter appointment date and time.',
            'client_name.required'          => 'Please enter client name.',
            'client_egn.required'           => 'Please enter client EGN.',
             ];
    }
}
