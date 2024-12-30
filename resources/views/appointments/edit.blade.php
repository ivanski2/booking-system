@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Edit Appointment #{{ $appointment->id }}</h1>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label for="appointment_datetime" class="form-label">Date/Time</label>
                    <input type="datetime-local"
                           name="appointment_datetime"
                           id="appointment_datetime"
                           class="form-control"
                           value="{{ old('appointment_datetime', \Carbon\Carbon::parse($appointment->appointment_datetime)->format('Y-m-d\TH:i')) }}">
                </div>

                <div class="col-md-6">
                    <label for="client_name" class="form-label">Client Name</label>
                    <input type="text"
                           name="client_name"
                           id="client_name"
                           class="form-control"
                           value="{{ old('client_name', $appointment->client_name) }}">
                </div>

                <div class="col-md-6">
                    <label for="client_egn" class="form-label">EGN</label>
                    <input type="text"
                           name="client_egn"
                           id="client_egn"
                           class="form-control"
                           value="{{ old('client_egn', $appointment->client_egn) }}">
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description"
                              id="description"
                              class="form-control"
                              rows="3">{{ old('description', $appointment->description) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label for="notification_type" class="form-label">Notification Type</label>
                    <select name="notification_type" id="notification_type" class="form-select">
                        <option value="SMS"   {{ old('notification_type', $appointment->notification_type) == 'SMS' ? 'selected' : '' }}>SMS</option>
                        <option value="Email" {{ old('notification_type', $appointment->notification_type) == 'Email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
