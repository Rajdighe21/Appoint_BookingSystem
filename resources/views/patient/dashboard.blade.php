<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patients Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 px-4">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Welcome, {{ Auth::user()->name }}</h1>
            <a href="{{ route('patient.logout') }}" class="text-red-500 hover:text-red-700 font-semibold">Logout</a>
        </header>
        @if (session('success'))
            <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif


        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Your Appointments</h2>
            <form action="{{route('appointments.filter')}}" method="GET" class="mb-4 flex items-center space-x-4">
                <label for="filter_date" class="block text-sm font-medium text-gray-700">Filter by Date:</label>
                <input type="date" id="filter_date" name="filter_date"
                    class="border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" required>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Filter</button>
            </form>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Doctor Name</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Date & Time</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="py-3 px-4 border-b">Dr.
                                    {{ $appointment->doctor ? $appointment->doctor->name : 'N/A' }}</td>
                                <td class="py-3 px-4 border-b">{{ $appointment->appointment_time }}</td>
                                <td class="py-3 px-4 border-b text-gray-800 font-medium">{{ $appointment->status }}</td>
                                <td class="py-3 px-4 border-b">
                                    <form action="{{ route('appointments.cancel', $appointment) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mt-8 mb-4 text-gray-700">Book a New Appointment</h2>
            <form action="{{ route('appointments.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                @csrf
                <div class="mb-4">

                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Select Doctor</label>
                    <select id="doctor_id" name="doctor_id" required
                        class="border border-gray-300 rounded w-full px-3 py-2 focus:ring-2 focus:ring-blue-400">
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->user_id }}"> {{ optional($doctor->user)->name ?? 'NA' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">

                    <input type="hidden" name="patient_id" value="{{ Auth::user()->id }}">

                    <label for="appointment_time" class="block text-sm font-medium text-gray-700">Date &
                        Time</label>
                    <input type="datetime-local" id="appointment_time" name="appointment_time" required
                        class="border border-gray-300 rounded w-full px-3 py-2 focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                    Book Appointment
                </button>
            </form>
        </section>
    </div>
</body>

</html>
