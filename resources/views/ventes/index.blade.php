{{-- On hérite de la structure de base (layout) définie dans 'layouts.app' --}}
@extends('layouts.app')

{{-- On définit le contenu de la section 'content' du layout --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- En-tête de la carte, avec le titre et le bouton pour créer une nouvelle vente --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Page de Vente de Téléphones') }}</span>
                    {{-- Le helper route() génère l'URL pour la route nommée 'ventes.create' --}}
                    <a href="{{ route('ventes.create') }}" class="btn btn-primary">Enregistrer une vente</a>
                </div>

                <div class="card-body">
                    {{-- Section de l'historique des ventes --}}
                    <h2 class="text-center mb-4">Historique des Ventes</h2>
                    
                    {{-- On vérifie si la collection $ventes (passée par le contrôleur) n'est pas vide --}}
                    @if ($ventes->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Vente</th>
                                        <th>Téléphone</th>
                                        <th>Client</th>
                                        <th>Vendeur</th>
                                        <th>Quantité</th>
                                        <th>Prix Total</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- On boucle sur chaque vente pour l'afficher dans une ligne du tableau --}}
                                    @foreach ($ventes as $vente)
                                    <tr>
                                        <td>{{ $vente->id }}</td>
                                        {{-- On accède aux informations des modèles liés (ex: $vente->telephone->name) grâce aux relations Eloquent --}}
                                        <td>{{ $vente->telephone->name ?? 'N/A' }} ({{ $vente->telephone->model ?? 'N/A' }})</td>
                                        <td>{{ $vente->client->name ?? 'N/A' }}</td>
                                        <td>{{ $vente->vendeur->name ?? 'N/A' }}</td>
                                        <td>{{ $vente->quantity }}</td>
                                        {{-- number_format() pour un affichage propre du prix --}}
                                        <td>{{ number_format($vente->price, 2, ',', ' ') }} CFA</td>
                                        <td>{{ optional($vente->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            {{-- Liens vers les actions pour chaque vente (Voir, Modifier) --}}
                                            <a href="{{ route('ventes.show', $vente) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('ventes.edit', $vente) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            
                                            {{-- Le bouton supprimer est dans un formulaire pour pouvoir envoyer une requête de type DELETE --}}
                                            <form action="{{ route('ventes.destroy', $vente) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                                {{-- @csrf est une protection de sécurité indispensable dans Laravel --}}
                                                @csrf
                                                {{-- @method('DELETE') spécifie la méthode HTTP, car les navigateurs ne supportent que GET et POST nativement --}}
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Message affiché si aucune vente n'a été trouvée --}}
                        <p class="text-center">Aucune vente enregistrée pour le moment.</p>
                    @endif

                    <hr>

                    {{-- Section pour afficher les téléphones disponibles --}}
                    <h2 class="text-center mb-4">Nos Téléphones Disponibles</h2>
                    <div class="row" id="phone-list">
                        {{-- On boucle sur la collection $telephones (passée par le contrôleur) --}}
                        @forelse ($telephones as $telephone)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($telephone->image)
                                    {{-- asset() génère une URL pour un fichier dans le dossier 'public' --}}
                                    <img src="{{ asset('images/' . $telephone->image) }}" class="card-img-top" alt="{{ $telephone->name }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $telephone->name }}</h5>
                                    <p class="card-text"><strong>Modèle:</strong> {{ $telephone->model }}</p>
                                    <p class="card-text"><strong>En Stock:</strong> {{ $telephone->stock }}</p>
                                    <h6 class="mt-auto mb-0"><strong>Prix:</strong> {{ number_format($telephone->price, 2, ',', ' ') }} €</h6>
                                </div>
                            </div>
                        </div>
                        @empty
                        {{-- Message affiché si aucun téléphone n'est disponible --}}
                        <div class="col-12 text-center">
                            <p>Aucun téléphone disponible à la vente pour le moment.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection