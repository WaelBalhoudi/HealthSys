@extends('layouts.app')

@section('title', 'Modifier un département')
@section('page-title', 'Modifier le département')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Modifier : {{ $departement->nom }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.departements.update', $departement) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nom du département <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $departement->nom) }}" required>
                        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $departement->description) }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.departements.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-custom">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection