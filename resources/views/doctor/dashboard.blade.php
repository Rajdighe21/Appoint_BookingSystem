<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Doctor | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="container mx-auto px-4 py-8">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
            <a href="{{ route('doctor.logout') }}" class="text-red-500 hover:text-red-700 font-semibold">Logout</a>
        </header>

        <form action="{{route('patient.appointments.filter')}}" method="GET" class="mb-4 flex items-center space-x-4">
            <label for="filter_date" class="block text-sm font-medium text-gray-700">Filter by Date:</label>
            <input type="date" id="filter_date" name="filter_date"
                class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" required>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Filter</button>
        </form>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-600">Patients
                        Name
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-600">Date &
                        Time</th>
                    <th class="py-3 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-600">Status
                    </th>
                    <th class="py-3 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-600">Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td class="py-4 px-4 border-b border-gray-200">{{ optional($appointment->user)->name ?? 'N/A' }}
                        </td>
                        <td class="py-4 px-4 border-b border-gray-200">{{ $appointment->appointment_time }}</td>
                        <td class="py-4 px-4 border-b border-gray-200">
                            <span
                                class=" font-semibold
    {{ $appointment->status == 'RSVP' ? 'text-yellow-500' : '' }}
     {{ $appointment->status == 'Approved' ? 'text-green-500' : '' }}
    {{ $appointment->status == 'Rejected' || $appointment->status == 'Cancelled' ? 'text-red-600' : '' }}">{{ $appointment->status }}</span>
                        </td>
                        <td class="py-4 px-4 border-b border-gray-200">
                            <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                                @csrf
                                <select name="status" class="form-control">
                                    <option value="approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>
                                        Approve</option>
                                    <option value="rejected" {{ $appointment->status == 'rejected' ? 'selected' : '' }}>
                                        Reject</option>
                                    <option value="cancelled"
                                        {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                </select>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Update
                                    Status</button>
                            </form>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</body>

</html>
