<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
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
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold text-center">Our Doctors</h1>
        <div class="flex space-x-4">
            <a href="{{ route('doctor.login') }}" class="text-blue-500 hover:underline">Doctor Login</a>
            <span>|</span>
            <a class="text-blue-500 hover:underline" onclick="openLoginModal()">
                User Login
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($doctors as $doctor)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                <img src="{{ asset('assets/image/' . $doctor->image) }}" alt="Doctor Image"
                    class="w-full h-48 object-cover" />
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ optional($doctor->user)->name ?? 'NA' }}</h2>
                    <p class="text-gray-600 mb-2">{{ $doctor->specialty }}</p>
                    <p class="text-gray-500 mb-4">Specialization: {{ $doctor->specialization }}</p>

                    <div class="flex justify-between items-center">
                        <p class="text-sm font-medium text-green-500">
                           Online Booking
                        </p>
                        @if (!$doctor->is_booked)
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                                onclick="openLoginModal()">
                                Book Now
                            </button>
                        @else
                            <button class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed"
                                disabled>
                                Booked
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>




    <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-xl font-semibold mb-4">Login to Book Appointment</h2>
            <form action="{{ route('patient.login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" required
                        class="border border-gray-300 rounded w-full px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required
                        class="border border-gray-300 rounded w-full px-3 py-2">
                </div>
                <div class="flex justify-end">
                    <a href="#" onclick="openRegisterModal()"
                        class="hover:text-blue-600 font-bold py-2 px-4 rounded mr-2">
                        Register
                    </a>
                    <button type="button" class="bg-gray-300 text-gray-700 py-2 px-4 rounded mr-2"
                        onclick="closeLoginModal()">
                        Cancel
                    </button>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Login
                    </button>

                </div>
            </form>
        </div>
    </div>





    <div id="registerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-xl font-semibold mb-4">Register</h2>
            <form action="{{ route('patient.register') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name" required
                        class="border border-gray-300 rounded w-full px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" required
                        class="border border-gray-300 rounded w-full px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" required
                        class="border border-gray-300 rounded w-full px-3 py-2">
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-300 text-gray-700 py-2 px-4 rounded mr-2"
                        onclick="closeRegisterModal()">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>







<script>
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }



    function openRegisterModal() {
        closeLoginModal();
        document.getElementById('registerModal').classList.remove('hidden');
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.add('hidden');
    }
</script>

</html>
