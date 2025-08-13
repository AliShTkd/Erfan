<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppointmentStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // مجوز دسترسی در کنترلر با میدلور auth بررسی می‌شود،
        // بنابراین اینجا به طور پیش‌فرض true قرار می‌دهیم.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // شناسه پزشک باید حتما ارسال شود و در جدول doctors موجود باشد.
            'doctor_id' => 'required|exists:doctors,id',

            // یادداشت بیمار اختیاری است، اما اگر ارسال شد باید از نوع رشته باشد.
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }

}
