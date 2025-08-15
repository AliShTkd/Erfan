<?php
namespace App\Repositories\Appointment;

use App\Http\Resources\Appointment\AppointmentIndexResource;
use App\Interfaces\Appointment\AppointmentInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // <--- این خط برای استفاده از Auth::user() ضروری است
use Illuminate\Support\Facades\Gate;

class AppointmentRepository implements AppointmentInterface
{
    // تعریف ساعات کاری و مدت زمان هر نوبت به عنوان ثابت
    const WORK_START_HOUR = 9;
    const WORK_END_HOUR = 17;
    const SLOT_DURATION_MINUTES = 15;

    public function index(): \Illuminate\Http\JsonResponse
    {
        // این متد برای پنل ادمین کاربرد دارد
        $data = Appointment::query();
        $data->with(['user', 'doctor.user']); // Eager loading برای بهینگی
        $data->orderBy(request('sort_by', 'appointment_time'), request('sort_type', 'desc'));
        return helper_response_fetch(AppointmentIndexResource::collection($data->paginate(request('per_page', 15)))->resource);
    }

    public function myAppointments(): \Illuminate\Http\JsonResponse
    {
        // نمایش نوبت‌های کاربر فعلی
        $user = Auth::user(); // <-- اصلاح شد: روش صحیح برای گرفتن کاربر لاگین کرده
        $data = Appointment::query()->where('user_id', $user->id);
        $data->with(['doctor.user']);
        $data->orderBy('appointment_time', 'desc');
        return helper_response_fetch(AppointmentIndexResource::collection($data->paginate(request('per_page', 15)))->resource);
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user(); // <-- اصلاح شد: روش صحیح برای گرفتن کاربر لاگین کرده
        $doctor = Doctor::findOrFail($request->doctor_id);

        // شروع جستجو از فردا (برای جلوگیری از رزرو در همان لحظه)
        $searchDate = Carbon::tomorrow();

        for ($day = 0; $day < 30; $day++) { // جستجو تا ۳۰ روز آینده
            $currentDay = $searchDate->copy()->addDays($day);

            if ($currentDay->isFriday()) { // فرض بر تعطیلی جمعه‌ها
                continue;
            }

            $dayStartTime = $currentDay->copy()->hour(self::WORK_START_HOUR)->minute(0)->second(0);
            $dayEndTime = $currentDay->copy()->hour(self::WORK_END_HOUR)->minute(0)->second(0);

            for ($slotTime = $dayStartTime->copy(); $slotTime < $dayEndTime; $slotTime->addMinutes(self::SLOT_DURATION_MINUTES)) {

                // بررسی تداخل نوبت برای خود کاربر (با هر پزشکی)
                $userHasAppointment = Appointment::where('user_id', $user->id)
                    ->where('appointment_time', $slotTime)
                    ->where('status', '!=', 'cancelled')
                    ->exists();

                if ($userHasAppointment) {
                    continue;
                }

                // بررسی پر بودن نوبت برای این پزشک
                $doctorHasAppointment = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_time', $slotTime)
                    ->where('status', '!=', 'cancelled')
                    ->exists();

                if (!$doctorHasAppointment) {
                    // نوبت خالی پیدا شد. آن را ثبت می‌کنیم.
                    $appointment = Appointment::create([
                        'user_id' => $user->id,
                        'doctor_id' => $doctor->id,
                        'appointment_time' => $slotTime,
                        'duration_minutes' => self::SLOT_DURATION_MINUTES,
                        'notes' => $request->notes,
                        'status' => 'confirmed'
                    ]);

                    return helper_response_created(new AppointmentIndexResource($appointment));
                }
            }
        }

        // اگر هیچ نوبتی پیدا نشد
        return helper_response_error('متاسفانه نوبت خالی در ۳۰ روز آینده یافت نشد.', 422);
    }

    public function show($item): \Illuminate\Http\JsonResponse
    {
        // بررسی اینکه کاربر فقط بتواند نوبت خودش را ببیند
//        Gate::authorize('view', $item);
//        return helper_response_fetch(new AppointmentIndexResource($item->load(['user', 'doctor.user'])));
        return helper_response_fetch(new AppointmentIndexResource($item));
    }

    public function cancel($item): \Illuminate\Http\JsonResponse
    {
        // بررسی اینکه کاربر فقط بتواند نوبت خودش را کنسل کند
        Gate::authorize('cancel', $item);

        if ($item->status === 'completed' || $item->status === 'cancelled') {
            return helper_response_error('این نوبت قابل کنسل شدن نیست.', 403);
        }

//        if (Carbon::now()->diffInHours($item->appointment_time) < 24) {
//            return helper_response_error('امکان کنسل کردن نوبت کمتر از ۲۴ ساعت مانده به آن وجود ندارد.', 403);
//        }

        $item->update(['status' => 'cancelled']);
        return helper_response_updated(new AppointmentIndexResource($item));
    }


    public function checkDoctorAppointment(Doctor $doctor)
    {
        $user = Auth::user();

        $appointment = \App\Models\Appointment::where('user_id', $user->id)
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('appointment_time', 'asc')
            ->first();

        if ($appointment) {
            // If an appointment is found, use the resource to return it
            return helper_response_fetch(new AppointmentIndexResource($appointment));
        }

        // If no appointment is found, return a simple, valid JSON response with a null result.
        // This prevents the 500 server error.
        return response()->json([
            'status' => 'success',
            'message' => 'No active appointment found.',
            'result' => null
        ], 200);
    }
}
