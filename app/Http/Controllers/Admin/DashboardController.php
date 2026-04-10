<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine');
    }

    public function index()
    {
        // Statistiques globales
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => User::where('role', 'doctor')->count(),
            'total_secretaries' => User::where('role', 'secretaire')->count(),
            'total_appointments' => Appointment::count(),
            'total_revenue' => Invoice::sum('amount'),
            'total_paid' => Invoice::sum('paid_amount'),
            'pending_payment' => Invoice::sum('amount') - Invoice::sum('paid_amount'),
        ];

        // Rendez-vous aujourd'hui
        $todayAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->whereDate('date_time', today())
            ->orderBy('date_time')
            ->get();

        // Rendez-vous par mois (pour le graphique)
        $monthlyAppointments = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyAppointments[] = Appointment::whereMonth('date_time', $i)
                ->whereYear('date_time', date('Y'))
                ->count();
        }

        // Derniers patients ajoutés
        $recentPatients = Patient::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers médecins ajoutés
        $recentDoctors = User::with('specialite')
            ->where('role', 'doctor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top médecins (par nombre de consultations)
        $topDoctors = Doctor::with('user')
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'todayAppointments',
            'monthlyAppointments',
            'recentPatients',
            'recentDoctors',
            'topDoctors'
        ));
    }

    public function getChartData()
    {
        $months = [];
        $appointments = [];
        $revenues = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create(null, $i, 1)->translatedFormat('F');
            $appointments[] = Appointment::whereMonth('date_time', $i)
                ->whereYear('date_time', date('Y'))
                ->count();
            $revenues[] = Invoice::whereMonth('created_at', $i)
                ->whereYear('created_at', date('Y'))
                ->sum('amount');
        }

        return response()->json([
            'months' => $months,
            'appointments' => $appointments,
            'revenues' => $revenues
        ]);
    }
}