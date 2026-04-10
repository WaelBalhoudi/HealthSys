<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordonnance médicale</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
        .print-btn {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-btn button {
            padding: 10px 20px;
            font-size: 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .prescription-box {
            border: 2px solid #000;
            padding: 20px;
            min-height: 500px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .doctor-info, .patient-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="no-print print-btn">
        <button onclick="window.print()">🖨️ Imprimer l'ordonnance</button>
    </div>

    <div class="prescription-box">
        <div class="header">
            <h1>ORDONNANCE MÉDICALE</h1>
            <p>HealthSys - Cabinet médical</p>
        </div>

        <div class="doctor-info">
            <strong>Dr. {{ $prescription->doctor->user->name }}</strong><br>
            Spécialité: {{ $prescription->doctor->specialty }}<br>
            N° inscription: {{ $prescription->doctor->registration_number }}<br>
            Tél: {{ $prescription->doctor->user->phone }}
        </div>

        <div class="patient-info">
            <strong>Patient: {{ $prescription->patient->user->name }}</strong><br>
            Date de naissance: {{ \Carbon\Carbon::parse($prescription->patient->user->birth_date)->format('d/m/Y') }}<br>
            Date: {{ $prescription->prescription_date->format('d/m/Y') }}
        </div>

        <h3>Médicaments prescrits:</h3>
        <table>
            <thead>
                <tr><th>Médicament</th><th>Dosage</th><th>Durée</th></tr>
            </thead>
            <tbody>
                @php $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true); @endphp
                @foreach($meds as $med)
                <tr><td>{{ $med['name'] ?? '' }}</td><td>{{ $med['dosage'] ?? '' }}</td><td>{{ $med['duration'] ?? '' }}</td></tr>
                @endforeach
            </tbody>
        </table>

        @if($prescription->instructions)
        <div class="instructions">
            <strong>Instructions:</strong><br>
            {{ $prescription->instructions }}
        </div>
        @endif

        <div class="signature">
            <br><br><br>
            _________________________<br>
            Signature et cachet
        </div>
    </div>

    <script>
        window.onload = function() {
            if (window.matchMedia('print').matches) {
                // Déjà en mode impression
            }
        }
    </script>
</body>
</html>