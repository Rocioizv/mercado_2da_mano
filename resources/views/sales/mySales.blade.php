@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Mis Productos</h2>
    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">⬅ Volver atrás</a>


    @if ($sales->isEmpty())
        <p>No has publicado ningún producto aún.</p>
    @else
        <div class="row">
            @foreach($sales as $sale)
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="{{ asset('storage/' . $sale->image) }}" class="card-img-top" alt="{{ $sale->product }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sale->product }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($sale->description, 60) }}</p>
                            <p class="card-text"><strong>Precio:</strong> €{{ number_format($sale->price, 2) }}</p>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-success">Ver más</a>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
