<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{

    public function doctorLogin()
    {
        return view('doctor.doctor_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if ($user->role === 'doctor') {
                return redirect()->intended('doctor/dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }


    public function DoctorDashboard(Request $request)
    {
        $doctorId = auth()->user()->id;
        $appointmentsQuery = Appointment::where('doctor_id', $doctorId);
        if ($request->filled('date')) {
            $appointmentsQuery->whereDate('appointment_date', $request->date);
        }
        // dd($appointmentsQuery);
        $appointments = $appointmentsQuery->get();
        return view('doctor.dashboard', compact('appointments'));
    }

    public function Patientsfilter(Request $request)
    {

        $query = Appointment::query();
        if ($request->filled('filter_date')) {
            $date = $request->input('filter_date');
            $query->whereDate('appointment_time', $date);
        }
        $appointments = $query->where('doctor_id', auth()->id())->get();
        return view('doctor.dashboard', compact('appointments'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index.view');
    }

    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $request->validate([
            'status' => 'required',
        ]);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->route('doctor.dashboard')->with('success', 'Appointment status updated successfully.');
    }


    public function DoctorRegister()
    {
        $lastId = User::max('id');
        return view('doctor.doctor_register', compact('lastId'));
    }

    public function DoctorRegisterStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        // dd($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);
        $doctorImage = 'doctor_' . rand(1, 7) . '.jfif';
        Doctor::create([
            'user_id' => $user->id,
            'image' => $doctorImage,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('index.view')->with('success', 'Doctor registered successfully.');
    }
}
