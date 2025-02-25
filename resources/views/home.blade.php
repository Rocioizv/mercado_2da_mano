
@extends('layouts.app')

@section('content')
<div class="container">


    <div class="d-flex justify-content-between mb-3">
        @auth
        <h2>Bienvenido, {{ Auth::user()->name }}</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Publicar un anuncio</a>
        @else
        <h2>Bienvenido</h2>
        <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar sesión</a>
        @endauth
    </div>

    <div class="row">
        @if(isset($sales) && !$sales->isEmpty())
        @foreach($sales as $sale)
        <div class="col-md-4">
            <div class="card product-card">
                <img src="{{ asset('storage/' . $sale->image) }}" class="card-img-top" alt="{{ $sale->product }}">
                <!-- @if($sale->issold)
                    <div class="sold-overlay">Vendido</div>
                @endif -->

                <div class="card-body">
                    <h5 class="card-title">{{ $sale->product }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($sale->description, 60) }}</p>
                    <p class="card-text"><strong>Precio:</strong> €{{ number_format($sale->price, 2) }}</p>
                    @auth
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-success">Ver más</a>
                        @if(!$sale->issold)
                            <form action="{{ route('sales.buy', $sale->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Comprar</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Vendido</button>
                        @endif
                    @else
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-success">Ver más</a>
                        <button class="btn btn-secondary" disabled>Inicia sesión para comprar</button>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p class="text-center mt-4">No hay productos en venta aún.</p>
        @endif
    </div>
</div>
@endsection