@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Gestion des Téléphones</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('telephones.create') }}"> Créer un nouveau téléphone</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th><a href="{{ route('telephones.names') }}">Nom</a></th>
                <th><a href="{{ route('telephones.models') }}">Modèle</a></th>
                <th><a href="{{ route('telephones.index', ['sort' => 'stock']) }}">Stock</a></th>
                <th>Prix</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($telephones as $telephone)
            <tr>
                <td>{{ $telephone->id }}</td>
                <td><img src="/images/{{ $telephone->image }}" width="100px"></td>
                <td>{{ $telephone->name }}</td>
                <td>{{ $telephone->model }}</td>
                <td>{{ $telephone->stock }}</td>
                <td>{{ $telephone->price }}</td>
                <td>
                    <form action="{{ route('telephones.destroy',$telephone->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('telephones.show',$telephone->id) }}">Voir</a>
                        <a class="btn btn-primary" href="{{ route('telephones.edit',$telephone->id) }}">Modifier</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection

