<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;

class AppointmentApiController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');
        $egn      = $request->input('egn');

        $query = Appointment::query();

        if ($dateFrom) {
            $query->where('appointment_datetime', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if ($dateTo) {
            $query->where('appointment_datetime', '<=', Carbon::parse($dateTo)->endOfDay());
        }
        if ($egn) {
            $query->where('client_egn', 'LIKE', "%{$egn}%");
        }

        $query->orderBy('appointment_datetime', 'asc');

        $appointments = $query->paginate(5)->appends($request->query());

        return response()->json([
            'success' => true,
            'data'    => $appointments,
        ], 200);
    }


    public function store(StoreAppointmentRequest $request, NotificationService $notificationService): JsonResponse
    {
        $appointment = Appointment::create($request->validated());

        $notifyMsg = $notificationService->notify(
            $appointment->notification_type,
            $appointment->client_name
        );

        return response()->json([
            'success'   => true,
            'message'   => "Успешно запазихте час! Клиентът ще бъде уведомен чрез {$appointment->notification_type}.",
            'notifyMsg' => $notifyMsg,
            'data'      => $appointment
        ], 201);
    }


    public function show(Appointment $appointment): JsonResponse
    {
        $futureAppointments = Appointment::where('client_egn', $appointment->client_egn)
            ->where('id', '!=', $appointment->id)
            ->where('appointment_datetime', '>', now())
            ->orderBy('appointment_datetime')
            ->get();

        return response()->json([
            'success'            => true,
            'data'               => $appointment,
            'future_appointments' => $futureAppointments,
        ], 200);
    }


    public function update(UpdateAppointmentRequest $request, Appointment $appointment, NotificationService $notificationService): JsonResponse
    {
        $appointment->update($request->validated());

        $notifyMsg = $notificationService->notify(
            $appointment->notification_type,
            $appointment->client_name
        );

        return response()->json([
            'success'   => true,
            'message'   => "Часът е обновен! Клиентът ще бъде уведомен чрез {$appointment->notification_type}.",
            'notifyMsg' => $notifyMsg,
            'data'      => $appointment,
        ], 200);
    }

    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Часът е изтрит успешно!'
        ], 200);
    }
}
