<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('index', compact('doctors'));
    }




    public function showBookingForm($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('booking', compact('doctor'));
    }




    public function loginPatient(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'patient') {
                $request->session()->regenerate();

                return redirect()->intended('/patient/dashboard');
            }
            Auth::logout();
            return redirect()->route('index.view')->with('error', 'Only Patients are allowed to log in!');
        }
        return redirect()->route('index.view')->with('error', 'Invalid credentials!');
    }



    public function redirect()
    {
        return redirect()->route('index.view');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('index.view');
    }


    public function dashboard()
    {
        $appointments = Appointment::with('doctor')
            ->where('patient_id', auth()->id())
            ->orderBy('appointment_time', 'desc')
            ->get();
        $doctors = Doctor::all();
        return view('patient.dashboard', compact('doctors', 'appointments'));
    }

    public function filter(Request $request)
    {
        $query = Appointment::query();
        if ($request->filled('filter_date')) {
            $date = $request->input('filter_date');
            $query->whereDate('appointment_time', $date);
        }
        $doctors = Doctor::all();
        $appointments = $query->where('patient_id', auth()->id())->get();
        return view('patient.dashboard', compact('appointments', 'doctors'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_time' => 'required',
        ]);

        $overlappingPatient = Appointment::where('patient_id', $request->patient_id)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($overlappingPatient) {
            return back()->with('error', 'You already have an appointment at this time.');
        }

        $overlappingDoctor = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($overlappingDoctor) {
            return back()->with('error', 'The doctor is not available at this time.');
        }
        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'status' => 'RSVP',
        ]);


        // dd($request->doctor_id);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment created successfully!');
    }




    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $appointment->delete();
        return redirect()->route('patient.dashboard')->with('success', 'Appointment canceled successfully!');
    }

    // public function Registerview(){
    //     return view('patient.patient_register');
    // }

    public function Patientregister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('index.view')->with('success', 'Registration successful! Please login.');
    }
}
