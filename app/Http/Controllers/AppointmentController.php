<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{

    public function index(Request $request)
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

        return view('appointments.index', compact('appointments'));
    }


    public function create()
    {
        return view('appointments.create');
    }


    public function store(StoreAppointmentRequest $request, NotificationService $notificationService)
    {
        $appointment = Appointment::create($request->validated());

        $notifyMsg = $notificationService->notify(
            $appointment->notification_type,
            $appointment->client_name
        );

        return redirect()
            ->route('appointments.index')
            ->with('success', "Successfully book an appointment! Client will be notified with  {$appointment->notification_type}. ({$notifyMsg})");
    }

    public function show(Appointment $appointment)
    {
        $futureAppointments = Appointment::where('client_egn', $appointment->client_egn)
            ->where('id', '!=', $appointment->id)
            ->where('appointment_datetime', '>', now())
            ->orderBy('appointment_datetime')
            ->get();

        return view('appointments.show', compact('appointment', 'futureAppointments'));
    }


    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }


    public function update(UpdateAppointmentRequest $request, Appointment $appointment, NotificationService $notificationService)
    {
        $appointment->update($request->validated());

        $notifyMsg = $notificationService->notify(
            $appointment->notification_type,
            $appointment->client_name
        );

        return redirect()
            ->route('appointments.index')
            ->with('success', "The time has been updated! The customer will be notified via {$appointment->notification_type}. ({$notifyMsg})");
    }


    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'The appointment has been deleted successfully!');
    }
}
