@extends('layouts.app')

@section('title', 'Ajouter une spécialité')
@section('page-title', 'Nouvelle spécialité')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ajouter une spécialité</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.specialites.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nom de la spécialité <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" required>
                        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.specialites.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection