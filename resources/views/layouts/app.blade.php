<!DOCTYPE html>
<html lang="fr">
<head>
    {{-- Définit l'encodage des caractères pour le document HTML --}}
    <meta charset="utf-8">
    {{-- Configure le viewport pour un affichage réactif sur différents appareils --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Titre de la page, peut être défini par les vues enfants. 'Gestion de Stock' est le titre par défaut. --}}
    <title>@yield('title', 'Gestion de Stock')</title>

    {{-- Inclusion du CSS de Bootstrap 5 depuis un CDN pour le style général de l'application --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Styles CSS personnalisés pour la mise en page (layout) --}}
    {{-- Pour des projets plus importants, il est recommandé de déplacer ces styles dans un fichier CSS externe. --}}
    <style>
        /* Le corps de la page prend au moins toute la hauteur de la fenêtre */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* Organise le contenu en colonne : header, main-container, (footer si existant) */
        }
        /* Conteneur principal qui contient la barre latérale et le contenu principal */
        .main-container {
            display: flex; /* Permet à la barre latérale et au contenu de s'afficher côte à côte */
            flex: 1; /* Prend l'espace disponible restant après le header */
        }
        /* Styles pour la barre latérale de navigation */
        .sidebar {
            width: 250px; /* Largeur fixe de la barre latérale */
            background: #f8f9fa; /* Couleur de fond gris clair */
            padding: 20px; /* Espacement intérieur */
        }
        /* Styles pour la zone de contenu principal */
        .content {
            flex: 1; /* Le contenu prend tout l'espace restant après la barre latérale */
            padding: 20px; /* Espacement intérieur */
        }
    </style>
</head>
<body>

{{-- Section de l'en-tête (Header) de l'application --}}
{{-- Ceci fait partie de la couche Vue de l'MVC, affichant les éléments de navigation globaux. --}}
<header class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        {{-- Lien vers la page d'accueil (liste des téléphones) --}}
        {{-- `route()` est une fonction Laravel qui génère une URL basée sur le nom de la route. --}}
        <a class="navbar-brand" href="{{ route('telephones.index') }}">AIDARA Stock</a>
    </div>
</header>

{{-- Conteneur principal de l'application, organisant la barre latérale et le contenu --}}
<div class="main-container">
    {{-- Barre latérale de navigation (Sidebar) --}}
    {{-- Propose des liens de navigation vers les différentes sections de l'application. --}}
    <div class="sidebar">
        <ul class="nav flex-column">
            {{-- Lien vers la gestion des téléphones --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('telephones.index') }}">Téléphones</a>
            </li>
            
            {{-- Lien vers la gestion des ventes --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ventes.index') }}">Ventes</a>
            </li>
            {{-- Lien vers la gestion des vendeurs --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('vendeurs.index') }}">Vendeurs</a>
            </li>
            {{-- Lien vers la gestion des clients --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('clients.index') }}">Clients</a>
            </li>
            {{-- Lien vers le tableau de bord (Dashboard) --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
        </ul>
    </div>
    {{-- Zone où le contenu spécifique de chaque page sera injecté --}}
    {{-- `@yield('content')` est une directive Blade qui marque un emplacement où les vues enfants peuvent "pousser" du contenu. --}}
    <div class="content">
        @yield('content')
    </div>
</div>

{{-- Inclusion du JavaScript de Bootstrap 5 depuis un CDN pour les fonctionnalités interactives (ex: navigation responsive, pop-ups) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>