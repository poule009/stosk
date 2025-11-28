@extends('layouts.app')

@section('title', 'Détails du Client')

@section('content')
    <div class="container">
        <h1>Détails du client</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $client->name }}</h5>
                
                <p class="card-text">
                    <strong>Email:</strong>
                    {{ $client->email ?? 'Non fourni' }}
                </p>
                
                <p class="card-text">
                    <strong>Téléphone:</strong>
                    {{ $client->phone ?? 'Non fourni' }}
                </p>
                
                <p class="card-text">
                    <strong>Adresse:</strong>
                    {{ $client->address ?? 'Non fournie' }}
                </p>

                <p class="card-text">
                    <small class="text-muted">
                        Créé le: {{ $client->created_at->format('d/m/Y H:i') }} |
                        Mis à jour le: {{ $client->updated_at->format('d/m/Y H:i') }}
                    </small>
                </p>

                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Modifier</a>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection
