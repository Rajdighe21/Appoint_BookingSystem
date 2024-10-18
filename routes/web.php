<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Models\Doctor;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppointmentController::class, 'index'])->name('index.view');
Route::get('/redirect', [AppointmentController::class, 'redirect'])->name('login');
Route::post('/login/patient', [AppointmentController::class, 'loginPatient'])->name('patient.login');
// Route::get('/patient/register', [AppointmentController::class, 'Registerview'])->name('Registerview');
Route::post('/patient/register', [AppointmentController::class, 'Patientregister'])->name('patient.register');


Route::middleware(['auth', 'can:isPatient'])->group(function () {
    Route::get('/patient/dashboard', [AppointmentController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/logout', [AppointmentController::class, 'logout'])->name('patient.logout');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/appointments/filter', [AppointmentController::class, 'filter'])->name('appointments.filter');
});





Route::get('/doctor/login', [DoctorController::class, 'doctorLogin'])->name('doctor.login');
Route::post('/doctor/login', [DoctorController::class, 'login'])->name('doctor.submit');
Route::get('doctor/register', [DoctorController::class, 'DoctorRegister'])->name('doctor.Register');
Route::post('doctor/register', [DoctorController::class, 'DoctorRegisterStore'])->name('doctor.Register.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'DoctorDashboard'])->name('doctor.dashboard');
    Route::get('doctor/logout', [DoctorController::class, 'logout'])->name('doctor.logout');
    Route::post('/doctor/appointments/update/{id}', [DoctorController::class, 'updateAppointment'])->name('appointments.update');
    Route::get('patient/appointments/filter', [DoctorController::class, 'Patientsfilter'])->name('patient.appointments.filter');

});
