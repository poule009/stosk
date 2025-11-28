@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center g-3">
        <div class="col-md-8">
            <h1 class="mb-0">{{ __('Détails du Vendeur') }}</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('vendeurs.index') }}" class="btn btn-secondary me-2" title="{{ __('Retour à la liste') }}">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Retour') }}
            </a>
            <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-warning" title="{{ __('Modifier') }}">
                <i class="fas fa-edit me-1"></i>{{ __('Modifier') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">{{ __('Informations du Vendeur') }}</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th class="w-25">{{ __('Nom') }}:</th>
                            <td>{{ $vendeur->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Email') }}:</th>
                            <td>{{ $vendeur->email ?? __('N/A') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Téléphone') }}:</th>
                            <td>{{ $vendeur->phone ?? __('N/A') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Créé le') }}:</th>
                            <td>{{ $vendeur->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Mis à jour le') }}:</th>
                            <td>{{ $vendeur->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">{{ __('Ventes Associées') }}</h5>
                    @if($vendeur->ventes->isEmpty())
                        <p class="text-muted">{{ __('Aucune vente associée.') }}</p>
                    @else
                        <ul class="list-group">
                            @foreach($vendeur->ventes as $vente)
                                <li class="list-group-item">
                                    <strong>{{ $vente->telephone->name ?? 'Téléphone inconnu' }}</strong> - {{ $vente->created_at->format('d/m/Y') }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
