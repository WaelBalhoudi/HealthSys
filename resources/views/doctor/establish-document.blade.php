@extends('layouts.app')

@section('title', 'Établir un document')
@section('page-title', 'Établir documents pour patient')

@section('styles')
<style>
    .patient-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .patient-card:hover {
        transform: translateX(5px);
        background-color: #f8f9fa;
        border-left-color: #1a5f7a;
    }
    .patient-card.selected {
        background-color: #e8f4f8;
        border-left-color: #1a5f7a;
    }
    .medication-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    .medication-item:hover {
        background: #e9ecef;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
    }
    .btn-generate {
        background: linear-gradient(135deg, #1a5f7a, #0d3b4f);
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 25px;
        transition: all 0.3s;
    }
    .btn-generate:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(26,95,122,0.3);
    }
    .btn-add-med {
        background: #f0b429;
        color: #1a5f7a;
        border: none;
        border-radius: 20px;
        padding: 5px 15px;
    }
    .btn-add-med:hover {
        background: #e5a800;
        transform: scale(1.02);
    }
    .search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    .selected-patient-info {
        background: linear-gradient(135deg, #1a5f7a, #0d3b4f);
        color: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        animation: slideDown 0.5s ease;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .nav-tabs .nav-link {
        color: #1a5f7a;
        font-weight: 500;
        border: none;
        padding: 10px 20px;
        transition: all 0.3s;
    }
    .nav-tabs .nav-link:hover {
        background: #f0b429;
        color: #1a5f7a;
        border-radius: 10px;
    }
    .nav-tabs .nav-link.active {
        background: #1a5f7a;
        color: white;
        border-radius: 10px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f0b429;
        box-shadow: 0 0 0 0.2rem rgba(240,180,41,0.25);
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-search text-primary"></i> Sélectionner un patient
                </h5>
            </div>
            <div class="card-body">
                <div class="position-relative">
                    <input type="text" id="searchPatient" class="form-control" placeholder="🔍 Rechercher par nom ou téléphone...">
                </div>
                <div id="patientList" class="mt-3" style="max-height: 400px; overflow-y: auto;"></div>
                <div id="loadingSpinner" class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div id="documentForm" style="display: none;">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <div id="selectedPatientInfo"></div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="documentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#ordonnance" type="button" role="tab">
                                <i class="fas fa-prescription"></i> Ordonnance
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#certificat" type="button" role="tab">
                                <i class="fas fa-file-medical"></i> Certificat médical
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rapport" type="button" role="tab">
                                <i class="fas fa-file-alt"></i> Compte rendu
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <!-- Ordonnance -->
                        <div class="tab-pane fade show active" id="ordonnance" role="tabpanel">
                            <form id="prescriptionForm">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-pills text-primary"></i> Médicaments prescrits
                                    </label>
                                    <div id="medicationsContainer">
                                        <div class="medication-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-5 mb-2 mb-md-0">
                                                    <input type="text" class="form-control" placeholder="Nom du médicament" required>
                                                </div>
                                                <div class="col-md-3 mb-2 mb-md-0">
                                                    <input type="text" class="form-control" placeholder="Dosage (ex: 500mg)" required>
                                                </div>
                                                <div class="col-md-3 mb-2 mb-md-0">
                                                    <input type="text" class="form-control" placeholder="Durée (ex: 7 jours)" required>
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    <button type="button" class="btn btn-sm text-danger" onclick="removeMedication(this)" style="background: none;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-add-med mt-2" onclick="addMedication()">
                                        <i class="fas fa-plus-circle"></i> Ajouter un médicament
                                    </button>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-info-circle text-info"></i> Instructions
                                    </label>
                                    <textarea id="instructions" class="form-control" rows="4" placeholder="Mode d'emploi, précautions, contre-indications..."></textarea>
                                </div>
                                
                                <div class="text-end">
                                    <button type="button" class="btn btn-generate" onclick="savePrescription()">
                                        <i class="fas fa-file-pdf"></i> Générer l'ordonnance
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Certificat médical -->
                        <div class="tab-pane fade" id="certificat" role="tabpanel">
                            <form id="certificateForm">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-tag text-warning"></i> Type de certificat
                                    </label>
                                    <select id="certificate_type" class="form-select">
                                        <option value="repos">📋 Certificat de repos</option>
                                        <option value="aptitude">✅ Certificat d'aptitude</option>
                                        <option value="vaccination">💉 Certificat de vaccination</option>
                                        <option value="sport">🏃 Certificat de sport</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-day"></i> Durée (jours)
                                    </label>
                                    <input type="number" id="certificate_duration" class="form-control" value="3" min="1">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-comment-medical"></i> Motif / Observations
                                    </label>
                                    <textarea id="certificate_reason" class="form-control" rows="4" placeholder="Motif du certificat..."></textarea>
                                </div>
                                
                                <div class="text-end">
                                    <button type="button" class="btn btn-generate" onclick="saveCertificate()">
                                        <i class="fas fa-file-pdf"></i> Générer le certificat
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Compte rendu -->
                        <div class="tab-pane fade" id="rapport" role="tabpanel">
                            <form id="reportForm">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-stethoscope text-success"></i> Diagnostic
                                    </label>
                                    <textarea id="report_diagnosis" class="form-control" rows="3" placeholder="Diagnostic médical..."></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-syringe text-danger"></i> Traitement proposé
                                    </label>
                                    <textarea id="report_treatment" class="form-control" rows="3" placeholder="Traitement et médicaments prescrits..."></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-list-check text-info"></i> Recommandations
                                    </label>
                                    <textarea id="report_recommendations" class="form-control" rows="3" placeholder="Recommandations et conseils..."></textarea>
                                </div>
                                
                                <div class="text-end">
                                    <button type="button" class="btn btn-generate" onclick="saveReport()">
                                        <i class="fas fa-file-pdf"></i> Générer le compte rendu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedPatientId = null;
let searchTimeout = null;

// Recherche de patient avec debounce
document.getElementById('searchPatient').addEventListener('keyup', function() {
    clearTimeout(searchTimeout);
    const search = this.value;
    
    if(search.length < 2) {
        document.getElementById('patientList').innerHTML = '';
        return;
    }
    
    searchTimeout = setTimeout(() => {
        document.getElementById('loadingSpinner').style.display = 'block';
        
        fetch(`/patients/search?q=${encodeURIComponent(search)}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingSpinner').style.display = 'none';
                let html = '<div class="list-group">';
                if(data.length === 0) {
                    html += '<div class="text-center text-muted p-3">Aucun patient trouvé</div>';
                } else {
                    data.forEach(patient => {
                        html += `
                            <div class="list-group-item list-group-item-action patient-card" onclick="selectPatient(${patient.id}, '${patient.user.name}', '${patient.user.phone}', '${patient.user.email}')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><i class="fas fa-user-circle"></i> ${patient.user.name}</strong><br>
                                        <small class="text-muted"><i class="fas fa-phone"></i> ${patient.user.phone}</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-primary"></i>
                                </div>
                            </div>
                        `;
                    });
                }
                html += '</div>';
                document.getElementById('patientList').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('loadingSpinner').style.display = 'none';
                console.error('Erreur:', error);
            });
    }, 500);
});

function selectPatient(id, name, phone, email) {
    selectedPatientId = id;
    
    const infoHtml = `
        <div class="selected-patient-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-circle fa-2x me-3"></i>
                    <div class="d-inline-block">
                        <h5 class="mb-0">${name}</h5>
                        <small><i class="fas fa-phone"></i> ${phone} &nbsp;|&nbsp; <i class="fas fa-envelope"></i> ${email}</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light" onclick="changePatient()">
                    <i class="fas fa-exchange-alt"></i> Changer
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('selectedPatientInfo').innerHTML = infoHtml;
    document.getElementById('documentForm').style.display = 'block';
    document.getElementById('searchPatient').value = '';
    document.getElementById('patientList').innerHTML = '';
}

function changePatient() {
    selectedPatientId = null;
    document.getElementById('documentForm').style.display = 'none';
    document.getElementById('selectedPatientInfo').innerHTML = '';
    document.getElementById('searchPatient').disabled = false;
    document.getElementById('searchPatient').value = '';
    document.getElementById('searchPatient').focus();
}

function addMedication() {
    const container = document.getElementById('medicationsContainer');
    const div = document.createElement('div');
    div.className = 'medication-item';
    div.innerHTML = `
        <div class="row align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Nom du médicament" required>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Dosage (ex: 500mg)" required>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <input type="text" class="form-control" placeholder="Durée (ex: 7 jours)" required>
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-sm text-danger" onclick="removeMedication(this)" style="background: none;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(div);
    div.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function removeMedication(btn) {
    const container = document.getElementById('medicationsContainer');
    if(container.children.length > 1) {
        btn.closest('.medication-item').remove();
    } else {
        showToast('warning', 'Vous devez avoir au moins un médicament');
    }
}

function showToast(type, message) {
    // Créer un toast simple
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed bottom-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.style.animation = 'slideUp 0.3s ease';
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function savePrescription() {
    if(!selectedPatientId) {
        showToast('warning', 'Veuillez sélectionner un patient');
        return;
    }
    
    const medicaments = [];
    const items = document.querySelectorAll('#medicationsContainer .medication-item');
    let valid = true;
    
    items.forEach(item => {
        const name = item.querySelector('input:nth-child(1)')?.value;
        const dosage = item.querySelector('input:nth-child(2)')?.value;
        const duration = item.querySelector('input:nth-child(3)')?.value;
        
        if(!name || !dosage || !duration) {
            valid = false;
        }
        
        medicaments.push({ name, dosage, duration });
    });
    
    if(!valid) {
        showToast('warning', 'Veuillez remplir tous les champs des médicaments');
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
    btn.disabled = true;
    
    fetch('{{ route("doctor.store-prescription") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            patient_id: selectedPatientId,
            medications: medicaments,
            instructions: document.getElementById('instructions').value
        })
    }).then(response => response.json()).then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        if(data.success) {
            window.open(data.pdf_url, '_blank');
            showToast('success', 'Ordonnance générée avec succès !');
            document.getElementById('prescriptionForm').reset();
            // Réinitialiser les médicaments à un seul
            const container = document.getElementById('medicationsContainer');
            while(container.children.length > 1) {
                container.lastChild.remove();
            }
        } else {
            showToast('danger', 'Erreur lors de la génération');
        }
    }).catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showToast('danger', 'Erreur réseau');
    });
}

function saveCertificate() {
    if(!selectedPatientId) {
        showToast('warning', 'Veuillez sélectionner un patient');
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
    btn.disabled = true;
    
    fetch('{{ route("doctor.store-certificate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            patient_id: selectedPatientId,
            type: document.getElementById('certificate_type').value,
            duration: document.getElementById('certificate_duration').value,
            reason: document.getElementById('certificate_reason').value
        })
    }).then(response => response.json()).then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        if(data.success) {
            window.open(data.pdf_url, '_blank');
            showToast('success', 'Certificat généré avec succès !');
            document.getElementById('certificateForm').reset();
            document.getElementById('certificate_duration').value = 3;
        } else {
            showToast('danger', 'Erreur lors de la génération');
        }
    }).catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showToast('danger', 'Erreur réseau');
    });
}

function saveReport() {
    if(!selectedPatientId) {
        showToast('warning', 'Veuillez sélectionner un patient');
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
    btn.disabled = true;
    
    fetch('{{ route("doctor.store-report") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            patient_id: selectedPatientId,
            diagnosis: document.getElementById('report_diagnosis').value,
            treatment: document.getElementById('report_treatment').value,
            recommendations: document.getElementById('report_recommendations').value
        })
    }).then(response => response.json()).then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        if(data.success) {
            window.open(data.pdf_url, '_blank');
            showToast('success', 'Compte rendu généré avec succès !');
            document.getElementById('reportForm').reset();
        } else {
            showToast('danger', 'Erreur lors de la génération');
        }
    }).catch(error => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        showToast('danger', 'Erreur réseau');
    });
}

// Animation CSS pour les toasts
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection