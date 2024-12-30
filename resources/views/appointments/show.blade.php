@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Appointment Details (ID: {{ $appointment->id }})</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong>Appointment Info</strong>
        </div>
        <div class="card-body">
            <p><strong>Date/Time:</strong> {{ $appointment->appointment_datetime }}</p>
            <p><strong>Client Name:</strong> {{ $appointment->client_name }}</p>
            <p><strong>EGN:</strong> {{ $appointment->client_egn }}</p>
            <p><strong>Description:</strong> {{ $appointment->description ?? '---' }}</p>
            <p><strong>Notification Type:</strong> {{ $appointment->notification_type }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h5>Other Upcoming Appointments for this client:</h5>
        @if($futureAppointments->count())
            <table class="table table-bordered table-striped mt-2">
                <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Date/Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($futureAppointments as $fa)
                    <tr>
                        <td>{{ $fa->id }}</td>
                        <td>{{ $fa->appointment_datetime }}</td>
                        <td>
                            <a href="{{ route('appointments.show', $fa->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('appointments.edit', $fa->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No upcoming appointments for this client.</p>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </form>
    </div>
@endsection
