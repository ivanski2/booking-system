@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Appointment List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('appointments.index') }}" class="row g-3 mb-4">
        <div class="col-auto">
            <label for="date_from" class="visually-hidden">Date From</label>
            <input type="date" name="date_from" id="date_from"
                   class="form-control" placeholder="Date From"
                   value="{{ request('date_from') }}">
        </div>
        <div class="col-auto">
            <label for="date_to" class="visually-hidden">Date To</label>
            <input type="date" name="date_to" id="date_to"
                   class="form-control" placeholder="Date To"
                   value="{{ request('date_to') }}">
        </div>
        <div class="col-auto">
            <label for="egn" class="visually-hidden">EGN</label>
            <input type="text" name="egn" id="egn"
                   class="form-control" placeholder="EGN"
                   value="{{ request('egn') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('appointments.create') }}" class="btn btn-success">Add New Appointment</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date/Time</th>
            <th>Client</th>
            <th>EGN</th>
            <th>Notification</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($appointments as $ap)
            <tr>
                <td>{{ $ap->id }}</td>
                <td>{{ $ap->appointment_datetime }}</td>
                <td>{{ $ap->client_name }}</td>
                <td>{{ $ap->client_egn }}</td>
                <td>{{ $ap->notification_type }}</td>
                <td class="text-center">
                    <a href="{{ route('appointments.show', $ap->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('appointments.edit', $ap->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('appointments.destroy', $ap->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this appointment?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No appointments found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div>
        {{ $appointments->links() }}
    </div>
@endsection
