@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier la Vente') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ventes.update', $vente) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="telephone_id" class="col-md-4 col-form-label text-md-end">{{ __('Téléphone') }}</label>
                            <div class="col-md-6">
                                <select id="telephone_id" class="form-control @error('telephone_id') is-invalid @enderror" name="telephone_id" required>
                                    <option value="">Sélectionnez un téléphone</option>
                                    @foreach($telephones as $telephone)
                                        <option value="{{ $telephone->id }}" {{ old('telephone_id', $vente->telephone_id) == $telephone->id ? 'selected' : '' }}>
                                            {{ $telephone->name }} ({{ $telephone->model }}) - Stock: {{ $telephone->stock }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('telephone_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="client_id" class="col-md-4 col-form-label text-md-end">{{ __('Client') }}</label>
                            <div class="col-md-6">
                                <select id="client_id" class="form-control @error('client_id') is-invalid @enderror" name="client_id" required>
                                    <option value="">Sélectionnez un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $vente->client_id) == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="vendeur_id" class="col-md-4 col-form-label text-md-end">{{ __('Vendeur') }}</label>
                            <div class="col-md-6">
                                <select id="vendeur_id" class="form-control @error('vendeur_id') is-invalid @enderror" name="vendeur_id" required>
                                    <option value="">Sélectionnez un vendeur</option>
                                    @foreach($vendeurs as $vendeur)
                                        <option value="{{ $vendeur->id }}" {{ old('vendeur_id', $vente->vendeur_id) == $vendeur->id ? 'selected' : '' }}>
                                            {{ $vendeur->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendeur_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity" class="col-md-4 col-form-label text-md-end">{{ __('Quantité') }}</label>
                            <div class="col-md-6">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $vente->quantity) }}" required min="1">
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Mettre à Jour la Vente') }}
                                </button>
                                <a href="{{ route('ventes.index') }}" class="btn btn-secondary">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
