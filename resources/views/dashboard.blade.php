{{--
    dashboard.blade.php

    Ce fichier représente la vue "dashboard" dans l'architecture MVC.
    Il est responsable de l'affichage d'un résumé des statistiques clés de l'application
    (produits, ventes, stock) et agit comme une interface utilisateur pour la navigation rapide.
    Les données affichées sont fournies par un contrôleur.
--}}

{{--
    La directive `@extends` indique que cette vue hérite de la mise en page (layout) 'layouts.app'.
    Cela signifie que le contenu de cette vue sera inséré dans le `@yield('content')`
    défini dans 'layouts/app.blade.php', ce qui assure une cohérence visuelle sur tout le site.
--}}
@extends('layouts.app')

{{--
    La directive `@section('content')` marque le début de la section de contenu
    qui sera injectée dans le layout parent.
--}}
@section('content')
<div class="container-fluid mt-4">
    {{-- Titre principal du tableau de bord --}}
    <h1 class="mb-4">Tableau de bord</h1>

    {{--
        Début de la grille Bootstrap pour organiser les cartes de statistiques.
        `.row` crée une ligne flexible, et `.col-md-4` indique que chaque colonne prendra
        4 unités sur 12 sur les écrans de taille moyenne et plus, permettant 3 cartes par ligne.
    --}}
    <div class="row">
        {{-- Carte affichant le nombre total de produits --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Nombre total de produits</h5>
                    {{-- Affichage de la variable $totalProducts passée par le contrôleur --}}
                    <p class="card-text text-center display-4 text-primary">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        {{-- Carte affichant les ventes totales (estimées) --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Ventes totales (estimées)</h5>
                    {{-- Affichage de la variable $totalSales formatée en devise --}}
                    <p class="card-text text-center display-4 text-success">${{ number_format($totalSales, 2) }}</p>
                    <p class="card-text text-center text-muted mt-2">
                        {{--
                            Note : Ce commentaire explique pourquoi le calcul des ventes est une estimation.
                            Dans une application réelle, ceci serait basé sur des transactions de vente enregistrées.
                            Le code commenté ci-dessous a été laissé à titre indicatif.
                        --}}
                        <!-- <small>
                            Note : Le calcul des ventes totales est une estimation basée sur la somme de tous les prix des produits
                            en raison de l'absence d'un système dédié au suivi des ventes. Ceci devrait être remplacé par des données de ventes réelles si disponibles.
                        </small> -->
                    </p>
                </div>
            </div>
        </div>

        {{-- Carte affichant le stock restant --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Stock restant</h5>
                    {{-- Affichage de la variable $totalStockRemaining --}}
                    <p class="card-text text-center display-4 text-warning">{{ $totalStockRemaining }}</p>
                </div>
            </div>
        </div>

        {{-- Carte avec un lien pour voir les téléphones à vendre --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Voir les Téléphones à Vendre</h5>
                    <p class="card-text text-center">
                        {{-- Bouton renvoyant à la route 'ventes.index' --}}
                        <a href="{{ route('ventes.index') }}" class="btn btn-primary mt-3">Aller à la Page de Vente</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
    La directive `@endsection` marque la fin de la section 'content'.
--}}
@endsection
