<!DOCTYPE html>
<html lang="fr">
<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestion de Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Styles CSS personnalisés pour la mise en page (layout) --}}
    {{-- Pour des projets plus importants,
         il est recommandé de déplacer ces styles dans un fichier CSS externe. 
         Note a moi meme je dois commence a faire les bonne pratique--}}
    <style>
      
      body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding-top: 56px; 
    padding-bottom: 56px; 
}

      .main-container {
    display: flex;
    flex: 1;
    margin-top: 0; 
    height: calc(100vh - 112px);
    overflow: hidden;
}
        
      .sidebar {
    width: 250px;
    background: #f8f9fa;
    padding: 20px;
    position: fixed;
    height: calc(100vh - 112px); 
    top: 56px;
    overflow-y: auto;
    z-index: 1000;
}
       
    .content {
    flex: 1;
    padding: 20px;
    margin-left: 250px;
    margin-top: 56px; 
    height: calc(100vh - 112px - 40px); 
    overflow-y: auto; 
}
       
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1030; 
        }
      
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
        height: calc(100vh - 112px);
        top: 56px;
    }
    .content {
        margin-left: 200px;
        margin-top: 56px;
    }
}
    </style>
</head>
<body>


<header class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('telephones.index') }}">AIDARA Stock</a>
       </div>
</header>

{{-- Conteneur principal de l'application, organisant la barre latérale et le contenu --}}
<div class="main-container">
    
    <div class="sidebar">
        <ul class="nav flex-column">

        <li class="nav-item">
                <a class="nav-link" href="{{ route('telephones.index') }}">Téléphones</a>
            </li>
            
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ventes.index') }}">Ventes</a>
            </li>
            {{-- Lien vers la gestion des vendeurs --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('vendeurs.index') }}">Vendeurs</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('clients.index') }}">Clients</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

<footer class="navbar navbar-dark bg-dark fixed-bottom">
    <div class="container-fluid">
        <span class="navbar-text">2025 By EL Hadji Malick Aidara Badiane ; c'etait tres amusant</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>