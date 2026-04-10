@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tableau de bord</h4>
            </div>
            <div class="card-body">
                <h4>Bienvenue, {{ auth()->user()->name }}!</h4>
                <p class="text-muted">Bienvenue sur HealthSys - Système de gestion de cabinet médical.</p>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Patients</h6>
                                <h2 class="mb-0">{{ \App\Models\Patient::count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Médecins</h6>
                                <h2 class="mb-0">{{ \App\Models\Doctor::count() }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Rendez-vous aujourd'hui</h6>
                                <h2 class="mb-0">{{ \App\Models\Appointment::whereDate('date_time', today())->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle"></i> Pour ajouter plus de fonctionnalités, exécutez les migrations manquantes.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection