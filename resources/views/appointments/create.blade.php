@extends('layouts.app')

@section('content')
    <h1>Add New Appointment</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <label>Date/Time:
            <input type="datetime-local" name="appointment_datetime" value="{{ old('appointment_datetime') }}">
        </label><br><br>

        <label>Client Name:
            <input type="text" name="client_name" value="{{ old('client_name') }}">
        </label><br><br>

        <label>EGN:
            <input type="text" name="client_egn" value="{{ old('client_egn') }}">
        </label><br><br>

        <label>Description:
            <textarea name="description">{{ old('description') }}</textarea>
        </label><br><br>

        <label>Notification Type:
            <select name="notification_type">
                <option value="SMS"  {{ old('notification_type') == 'SMS'  ? 'selected' : '' }}>SMS</option>
                <option value="Email"{{ old('notification_type') == 'Email'? 'selected' : '' }}>Email</option>
            </select>
        </label><br><br>

        <button type="submit">Save</button>
    </form>
@endsection
