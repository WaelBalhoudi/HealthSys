<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordonnance médicale</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
        }
        .header p {
            color: #7f8c8d;
            margin: 5px 0 0;
        }
        .doctor-info, .patient-info {
            margin-bottom: 30px;
        }
        .doctor-info {
            float: left;
            width: 50%;
        }
        .patient-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .clearfix {
            clear: both;
        }
        .medications {
            margin: 30px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .instructions {
            margin: 30px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #3498db;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ordonnance médicale</h1>
        <p>HealthSys - Cabinet médical</p>
    </div>

    <div class="doctor-info">
        <h3>Dr. {{ $prescription->doctor->user->name }}</h3>
        <p>Spécialité: {{ $prescription->doctor->specialty }}</p>
        <p>N° inscription: {{ $prescription->doctor->registration_number }}</p>
        <p>Tél: {{ $prescription->doctor->user->phone }}</p>
    </div>

    <div class="patient-info">
        <h3>{{ $prescription->patient->user->name }}</h3>
        <p>Date de naissance: {{ \Carbon\Carbon::parse($prescription->patient->user->birth_date)->format('d/m/Y') }}</p>
        <p>Tél: {{ $prescription->patient->user->phone }}</p>
        <p>Date: {{ $prescription->prescription_date->format('d/m/Y') }}</p>
    </div>

    <div class="clearfix"></div>

    <div class="medications">
        <h3>Médicaments prescrits:</h3>
        <table>
            <thead>
                <tr>
                    <th>Médicament</th>
                    <th>Dosage</th>
                    <th>Durée</th>
                </thead>
            <tbody>
                @php
                    $meds = is_array($prescription->medications) ? $prescription->medications : json_decode($prescription->medications, true);
                @endphp
                @foreach($meds as $med)
                <tr>
                    <td>{{ $med['name'] ?? '' }}</td>
                    <td>{{ $med['dosage'] ?? '' }}</td>
                    <td>{{ $med['duration'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($prescription->instructions)
    <div class="instructions">
        <h4>📋 Instructions:</h4>
        <p>{{ $prescription->instructions }}</p>
    </div>
    @endif

    @if($prescription->valid_until)
    <div class="validity">
        <p><strong>⚠️ Cette ordonnance est valable jusqu'au {{ \Carbon\Carbon::parse($prescription->valid_until)->format('d/m/Y') }}</strong></p>
    </div>
    @endif

    <div class="signature">
        <p>_________________________</p>
        <p>Signature et cachet du médecin</p>
    </div>

    <div class="footer">
        <p>HealthSys - Système de gestion de cabinet médical</p>
        <p>Cette ordonnance est délivrée électroniquement et fait foi</p>
    </div>
</body>
</html>