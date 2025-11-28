@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center g-3">
        <div class="col-md-8">
            <h1 class="mb-0">{{ __('Ajouter un Vendeur') }}</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('vendeurs.index') }}" class="btn btn-secondary" title="{{ __('Retour à la liste') }}">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Retour') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('vendeurs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Nom') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('Téléphone') }}</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Créer') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
