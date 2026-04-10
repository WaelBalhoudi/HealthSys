<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('documents.index');
    }

    public function search(Request $request)
    {
        $search = $request->q;
        
        $patient = Patient::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->first();
            
        if ($patient) {
            $documents = $patient->documents ?? [];
            return response()->json([
                'patient' => $patient->user,
                'documents' => $documents
            ]);
        }
        
        return response()->json(null);
    }

    public function print($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.print', compact('document'));
    }

    public function establish()
    {
        return view('doctor.establish-document');
    }

    public function storePrescription(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medications' => 'required|array',
            'instructions' => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => auth()->user()->doctor->id,
            'medications' => json_encode($request->medications),
            'instructions' => $request->instructions,
            'prescription_date' => now(),
            'status' => 'active',
        ]);

        $pdf = Pdf::loadView('pdf.prescription', compact('prescription'));
        $filename = 'ordonnance_' . $prescription->id . '_' . date('Y-m-d') . '.pdf';
        $pdf->save(storage_path('app/public/' . $filename));

        return response()->json([
            'success' => true, 
            'pdf_url' => '/storage/' . $filename
        ]);
    }

    public function storeCertificate(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'type' => 'required|string',
            'duration' => 'required|integer',
            'reason' => 'nullable|string',
        ]);

        $patient = Patient::with('user')->find($request->patient_id);
        
        $data = [
            'patient' => $patient,
            'type' => $request->type,
            'duration' => $request->duration,
            'reason' => $request->reason,
            'date' => now(),
            'doctor' => auth()->user()->doctor,
        ];

        $pdf = Pdf::loadView('pdf.certificate', $data);
        $filename = 'certificat_' . $patient->id . '_' . date('Y-m-d') . '.pdf';
        $pdf->save(storage_path('app/public/' . $filename));

        return response()->json([
            'success' => true,
            'pdf_url' => '/storage/' . $filename
        ]);
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $patient = Patient::with('user')->find($request->patient_id);
        
        $data = [
            'patient' => $patient,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'recommendations' => $request->recommendations,
            'date' => now(),
            'doctor' => auth()->user()->doctor,
        ];

        $pdf = Pdf::loadView('pdf.report', $data);
        $filename = 'compte_rendu_' . $patient->id . '_' . date('Y-m-d') . '.pdf';
        $pdf->save(storage_path('app/public/' . $filename));

        return response()->json([
            'success' => true,
            'pdf_url' => '/storage/' . $filename
        ]);
    }
}