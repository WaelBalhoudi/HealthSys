@extends('layouts.app')

@section('title', 'Documents patients')
@section('page-title', 'Documents')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-search"></i> Rechercher les documents d'un patient</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" id="searchPatient" class="form-control form-control-lg" placeholder="Entrez le nom du patient...">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-custom w-100" onclick="searchDocuments()">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
                <div id="patientInfo" class="mt-4" style="display: none;">
                    <div class="alert alert-info">
                        <strong>Patient :</strong> <span id="patientName"></span><br>
                        <strong>CIN :</strong> <span id="patientCin"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="documentsList" class="mt-4" style="display: none;">
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-file-alt"></i> Documents du patient</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Type de document</th>
                            <th>Date de dernier modification</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="documentsTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function searchDocuments() {
    const search = document.getElementById('searchPatient').value;
    if(search.length < 2) {
        alert('Veuillez entrer au moins 2 caractères');
        return;
    }
    
    fetch(`/documents/search?q=${search}`)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById('patientInfo').style.display = 'block';
                document.getElementById('patientName').innerText = data.patient.name;
                document.getElementById('patientCin').innerText = data.patient.cin;
                
                let html = '';
                if(data.documents.length > 0) {
                    data.documents.forEach(doc => {
                        html += `
                            <tr>
                                <td>
                                    <i class="fas ${doc.type_icon} me-2"></i> ${doc.type}
                                </td>
                                <td>${doc.date}</td>
                                <td>
                                    <a href="${doc.url}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-print"></i> Imprimer
                                    </a>
                                 </noscript?<span class="math-inline">\)
                            </td>
                        </tr>
                    `;
                    });
                } else {
                    html = '<tr><td colspan="3" class="text-center">Aucun document trouvé</td></tr>';
                }
                document.getElementById('documentsTable').innerHTML = html;
                document.getElementById('documentsList').style.display = 'block';
            } else {
                alert(data.message);
            }
        });
}
</script>
@endsection