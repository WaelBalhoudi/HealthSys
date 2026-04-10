<?php

namespace App\Http\Controllers;

use App\Exports\PatientsExport;
use App\Exports\AppointmentsExport;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chef_medecine,secretaire');
    }

    public function patients(Request $request)
    {
        $search = $request->search;
        return Excel::download(new PatientsExport($search), 'patients_' . date('Y-m-d') . '.xlsx');
    }

    public function appointments(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;
        $doctorId = $request->doctor_id;
        
        return Excel::download(
            new AppointmentsExport($startDate, $endDate, $status, $doctorId), 
            'rendez-vous_' . date('Y-m-d') . '.xlsx'
        );
    }

    public function invoices(Request $request)
    {
        $status = $request->status;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        return Excel::download(
            new InvoicesExport($status, $startDate, $endDate), 
            'factures_' . date('Y-m-d') . '.xlsx'
        );
    }
}