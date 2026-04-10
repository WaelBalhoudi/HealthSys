@extends('layouts.app')

@section('title', 'Rapports')
@section('page-title', 'Rapports et analyses')

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Rapport mensuel</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.monthly') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Sélectionner un mois</label>
                        <input type="month" name="month" class="form-control" value="{{ date('Y-m') }}">
                    </div>
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-chart-line"></i> Générer le rapport
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Rapport annuel</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.yearly') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Sélectionner une année</label>
                        <select name="year" class="form-control">
                            @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-chart-line"></i> Générer le rapport
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection