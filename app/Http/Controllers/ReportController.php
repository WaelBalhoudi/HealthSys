<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('reports.index');
    }

    public function monthly(Request $request)
{
        $month = $request->month ? Carbon::parse($request->month) : Carbon::now();
        
        $appointments = Appointment::whereYear('date_time', $month->year)
            ->whereMonth('date_time', $month->month)
            ->get();
        
        $stats = [
            'month' => $month->format('F Y'),
            'appointments_count' => $appointments->count(),
            'confirmed_appointments' => $appointments->where('status', 'confirmed')->count(),
            'cancelled_appointments' => $appointments->where('status', 'cancelled')->count(),
            'completed_appointments' => $appointments->where('status', 'completed')->count(),
            'new_patients' => Patient::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->count(),
            'total_revenue' => Invoice::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->sum('amount'),
            'total_paid' => Invoice::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->sum('paid_amount'),
            'pending_payment' => Invoice::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->sum('amount') - Invoice::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->sum('paid_amount'),
            'appointments_by_type' => [
                'general' => $appointments->where('type', 'general')->count(),
                'emergency' => $appointments->where('type', 'emergency')->count(),
                'follow_up' => $appointments->where('type', 'follow_up')->count(),
                'specialist' => $appointments->where('type', 'specialist')->count(),
            ]
        ];
        
        return view('reports.monthly', compact('stats', 'month'));
    }

    public function yearly(Request $request)
    {
        $year = $request->year ?? date('Y');
        
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = [
                'month' => Carbon::create($year, $i, 1)->format('F'),
                'appointments' => Appointment::whereYear('date_time', $year)->whereMonth('date_time', $i)->count(),
                'revenue' => Invoice::whereYear('created_at', $year)->whereMonth('created_at', $i)->sum('amount'),
            ];
        }
        
        $stats = [
            'year' => $year,
            'total_appointments' => Appointment::whereYear('date_time', $year)->count(),
            'total_patients' => Patient::whereYear('created_at', $year)->count(),
            'total_revenue' => Invoice::whereYear('created_at', $year)->sum('amount'),
            'total_paid' => Invoice::whereYear('created_at', $year)->sum('paid_amount'),
            'monthly_data' => $monthlyData,
        ];
        
        return view('reports.yearly', compact('stats', 'year'));
    }
}