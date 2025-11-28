@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product Names in Stock</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('telephones.index') }}"> retour</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
        </tr>
        @foreach ($names as $name)
        <tr>
            <td>{{ $name }}</td>
        </tr>
        @endforeach
    </table>
@endsection
