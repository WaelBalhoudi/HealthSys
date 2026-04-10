<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\WaitingRoomController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ComptabiliteController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MedicalRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalAssistantController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

// Routes pour tous les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->role == 'patient') {
            return view('patient.dashboard');
        } elseif ($user->role == 'doctor') {
            return view('doctor.dashboard');
        } elseif ($user->role == 'secretaire') {
            return view('secretaire.dashboard');
        } elseif ($user->role == 'chef_medecine') {
            return view('admin.dashboard');
        }
        
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes pour les patients
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments');
    Route::post('/appointments/book', [AppointmentController::class, 'bookOnline'])->name('book');
    Route::post('/appointments/cancel/{id}', [AppointmentController::class, 'cancelOnline'])->name('cancel');
    Route::get('/medical-record', [ConsultationController::class, 'patientMedicalRecord'])->name('medical-record');
    Route::get('/prescriptions', [PrescriptionController::class, 'patientPrescriptions'])->name('prescriptions');
    Route::get('/invoices', [InvoiceController::class, 'patientInvoices'])->name('invoices');
});

// Routes pour les médecins
Route::middleware(['auth', 'role:doctor,chef_medecine'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('doctor.dashboard');
    })->name('dashboard');
    Route::get('/waiting-room', [WaitingRoomController::class, 'doctorIndex'])->name('waiting-room');
    Route::post('/consultation/start/{waitingRoom}', [WaitingRoomController::class, 'startConsultation'])->name('consultation.start');
    Route::get('/consultations', [ConsultationController::class, 'doctorConsultations'])->name('consultations');
    Route::get('/history', [ConsultationController::class, 'visitHistory'])->name('history');
    Route::get('/establish-document', [DocumentController::class, 'establish'])->name('establish-document');
    Route::post('/establish-document/prescription', [DocumentController::class, 'storePrescription'])->name('store-prescription');
    Route::post('/establish-document/certificate', [DocumentController::class, 'storeCertificate'])->name('store-certificate');
    Route::post('/establish-document/report', [DocumentController::class, 'storeReport'])->name('store-report');
    Route::get('/patients', [DoctorController::class, 'myPatients'])->name('patients');
    Route::get('/notifications', [DoctorController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/mark-all', [DoctorController::class, 'markAllNotifications'])->name('notifications.mark-all');
    Route::post('/notifications/{id}/mark-read', [DoctorController::class, 'markNotificationRead'])->name('notifications.mark-read');
});

// Routes pour les secrétaires

Route::middleware(['auth', 'role:secretaire,chef_medecine'])->prefix('secretaire')->name('secretaire.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('secretaire.dashboard');
    })->name('dashboard');
    
    Route::get('/comptabilite', [ComptabiliteController::class, 'index'])->name('comptabilite');
    Route::get('/paiements', [ComptabiliteController::class, 'paiements'])->name('paiements');
    Route::get('/facture/create', [ComptabiliteController::class, 'createFacture'])->name('facture.create');
    Route::post('/facture', [ComptabiliteController::class, 'storeFacture'])->name('facture.store');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patients', PatientController::class);
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/search', [DocumentController::class, 'search'])->name('documents.search');
    Route::get('/waiting-room', [WaitingRoomController::class, 'secretaireIndex'])->name('waiting-room');
    Route::post('/waiting-room/add', [WaitingRoomController::class, 'add'])->name('waiting-room.add');
    Route::delete('/waiting-room/{waitingRoom}/remove', [WaitingRoomController::class, 'remove'])->name('waiting-room.remove');
});

// Routes pour le chef de médecine (admin)
Route::middleware(['auth', 'role:chef_medecine'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    
    // Gestion des médecins
    Route::resource('doctors', DoctorController::class);
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    
    // Gestion des secrétaires
    Route::resource('secretaries', SecretaryController::class);
    Route::get('/secretaries/create', [SecretaryController::class, 'create'])->name('secretaries.create');
    Route::post('/secretaries', [SecretaryController::class, 'store'])->name('secretaries.store');
    Route::get('/secretaries/{secretary}/edit', [SecretaryController::class, 'edit'])->name('secretaries.edit');
    Route::put('/secretaries/{secretary}', [SecretaryController::class, 'update'])->name('secretaries.update');
    Route::delete('/secretaries/{secretary}', [SecretaryController::class, 'destroy'])->name('secretaries.destroy');
    
    // Gestion des spécialités
    Route::resource('specialites', SpecialiteController::class);
    
    // Gestion des départements
    Route::resource('departements', DepartementController::class);
    // Rapports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
    // Exports
    Route::get('/export/patients', [ExportController::class, 'patients'])->name('export.patients');
    Route::get('/export/appointments', [ExportController::class, 'appointments'])->name('export.appointments');
    Route::get('/export/invoices', [ExportController::class, 'invoices'])->name('export.invoices');
    Route::get('/consultations/{consultation}/details', [ConsultationController::class, 'details'])->name('consultations.details');
    Route::get('/patient/prescriptions', [PrescriptionController::class, 'patientPrescriptions'])->name('patient.prescriptions');
    Route::get('/patient/invoices', [InvoiceController::class, 'patientInvoices'])->name('patient.invoices');
    });


    Route::post('/test-upload', function(Request $request) {
        if ($request->hasFile('test_image')) {
            $path = $request->file('test_image')->store('test', 'public');
            return "File uploaded to: " . $path;
        }
        return "No file uploaded";

    });
    