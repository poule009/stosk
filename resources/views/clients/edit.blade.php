@extends('layouts.app')

@section('title', 'Modifier le Client')

@section('content')
    <div class="container">
        <h1>Modifier le client</h1>

        {{-- Affiche les erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire de modification de client --}}
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf  {{-- Protection contre les attaques CSRF --}}
            @method('PUT') {{-- Spécifie la méthode HTTP PUT pour la mise à jour --}}

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $client->name) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $client->email) }}">
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $client->phone) }}">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adresse</label>
                <textarea class="form-control" id="address" name="address">{{ old('address', $client->address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
