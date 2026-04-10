@extends('layouts.app')

@section('title', 'Mes rendez-vous')
@section('page-title', 'Prendre ou annuler un rendez-vous')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="welcome-card text-center">
            <h2 class="mb-0">Prendre un rendez-vous</h2>
            <p>dans un des meilleurs cabinet médical , nous avons les meilleurs médecins , avec les derniers types de technologie</p>
            <div class="mt-3">
                <a href="#prendre" class="btn btn-custom-primary me-2">Prendre rendez-vous</a>
                <a href="#annuler" class="btn btn-custom-outline">Annuler rendez-vous</a>
            </div>
        </div>
    </div>
</div>

<div class="row" id="prendre">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-calendar-plus"></i> Prendre un rendez-vous</h5>
            </div>
            <div class="card-body">
                <form id="appointmentForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Médecin</label>
                        <select id="doctor_id" class="form-control" required>
                            <option value="">Choisir un médecin</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }} - {{ $doctor->specialty }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" id="date" class="form-control" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motif</label>
                        <textarea id="reason" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-custom w-100" onclick="bookAppointment()">
                        Prendre rendez-vous
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Mes rendez-vous</h5>
            </div>
            <div class="card-body" id="myAppointments">
                <!-- Les rendez-vous seront chargés ici -->
            </div>
        </div>
    </div>
</div>

<script>
function loadAppointments() {
    fetch('{{ route("patient.appointments") }}')
        .then(response => response.json())
        .then(data => {
            let html = '';
            if(data.length > 0) {
                data.forEach(app => {
                    html += `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Dr. ${app.doctor.user.name}</strong><br>
                                    <small>${new Date(app.date_time).toLocaleDateString()} à ${new Date(app.date_time).toLocaleTimeString()}</small>
                                    <br><span class="badge bg-${app.status == 'confirmed' ? 'success' : 'warning'}">${app.status}</span>
                                </div>
                                <button class="btn btn-danger btn-sm" onclick="cancelAppointment(${app.id})">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = '<p class="text-muted text-center">Aucun rendez-vous</p>';
            }
            document.getElementById('myAppointments').innerHTML = html;
        });
}

function bookAppointment() {
    const doctor_id = document.getElementById('doctor_id').value;
    const date = document.getElementById('date').value;
    const reason = document.getElementById('reason').value;
    
    if(!doctor_id || !date) {
        alert('Veuillez remplir tous les champs');
        return;
    }
    
    fetch('{{ route("patient.book") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ doctor_id, date, reason })
    }).then(response => response.json()).then(data => {
        if(data.success) {
            alert('Rendez-vous pris avec succès');
            loadAppointments();
            document.getElementById('appointmentForm').reset();
        } else {
            alert('Erreur: ' + data.message);
        }
    });
}

function cancelAppointment(id) {
    if(confirm('Annuler ce rendez-vous ?')) {
        fetch(`{{ url("patient/appointments/cancel") }}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json()).then(data => {
            if(data.success) {
                alert('Rendez-vous annulé');
                loadAppointments();
            } else {
                alert('Erreur');
            }
        });
    }
}

loadAppointments();
</script>
@endsection