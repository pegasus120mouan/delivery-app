@extends('layout.main')

@section('title', 'Associer un gérant')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <h2>Associer un gérant au service : {{ $delivery_service->nom }}</h2>
    </div>

    <div class="card p-4">
        <form action="{{ route('delivery_services.updateGerant', $delivery_service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="gerant_id">Choisir un gérant</label>
                <select name="gerant_id" id="gerant_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($gerants as $gerant)
                        <option value="{{ $gerant->id }}">
                            {{ $gerant->nom }} {{ $gerant->prenoms }} ({{ $gerant->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                Associer
            </button>
            <a href="{{ route('delivery_services.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </form>
    </div>
</div>
@endsection
