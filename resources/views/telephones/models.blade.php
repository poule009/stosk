@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Modèles de téléphones en stock</h1>

        @if($models->isEmpty())
            <div class="p-6 bg-white rounded-lg shadow-md">
                <p class="text-gray-700">Aucun modèle en stock pour le moment.</p>
            </div>
        @else
            <div class="p-6 bg-white rounded-lg shadow-md">
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($models as $model)
                        <li>{{ $model }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection