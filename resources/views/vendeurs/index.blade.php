@extends('layouts.app')

@section('content')
<div class="container py-4" x-data>
    <div class="row mb-4 align-items-center g-3">
        <div class="col-md-8">
            <h1 class="mb-0">{{ __('Liste des Vendeurs') }}</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('vendeurs.create') }}" class="btn btn-primary" title="{{ __('Ajouter un nouveau vendeur') }}">
                <i class="fas fa-plus me-1"></i>{{ __('Ajouter') }}
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($vendeurs->isEmpty())
                <div class="alert alert-info mb-0" role="alert">
                    {{ __('Aucun vendeur n\'a été trouvé.') }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-lg-table-cell">Téléphone</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendeurs as $vendeur)
                                <tr>
                                    <td>{{ $vendeur->name }}</td>
                                    <td>{{ $vendeur->email }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $vendeur->phone ?? __('N/A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('vendeurs.show', $vendeur) }}" class="btn btn-sm btn-info" title="{{ __('Voir les détails') }}"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('vendeurs.edit', $vendeur) }}" class="btn btn-sm btn-warning" title="{{ __('Modifier') }}"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('vendeurs.destroy', $vendeur) }}" method="POST" class="d-inline"onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce vendeur ');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ __('Supprimer') }}"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 d-flex justify-content-center">
                    {{ $vendeurs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection