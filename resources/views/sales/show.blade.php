@extends('layouts.app')

@section('content')
<a href="{{ route('home') }}" class="btn btn-secondary mt-3">⬅ Volver atrás</a>
<div class="container mt-4">
    <div class="card product-detail-card">
        <div class="row">
            <!-- Imágenes del producto -->
            <div class="col-md-6">
                <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('storage/' . $sale->image) }}" class="d-block w-100" alt="{{ $sale->product }}">
                        </div>
                        @foreach ($sale->images as $image)
                        <div class="carousel-item">
                            <img src="{{ asset('storage/' . $image->route) }}" class="d-block w-100" alt="Imagen del producto">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselImages" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselImages" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>
            </div>

            <!-- Información del producto -->
            <div class="card">
                <!-- <img src="{{ asset('storage/' . $sale->image) }}" class="card-img-top" alt="{{ $sale->product }}"> -->
                <div class="card-body">
                    <h5 class="card-title">{{ $sale->product }}</h5>
                    <p class="card-text">{{ $sale->description }}</p>
                    <p class="card-text"><strong>Precio:</strong> €{{ number_format($sale->price, 2) }}</p>
                    <p class="card-text"><strong>Vendedor:</strong> {{ $sale->user->name }}</p>

   

                    @auth
                    @if(Auth::id() === $sale->user_id)
                  
                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Editar</a>

                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                    </form>
                    @if($sale->issold)
                    <form action="{{ route('sales.relist', $sale->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Reponer en venta</button>
                    </form>
                    @endif
                    @else
                    
                    @if(!$sale->issold)
                    <form action="{{ route('sales.buy', $sale->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Comprar</button>
                    </form>
                    @else
                    <button class="btn btn-secondary" disabled>Vendido</button>
                    @endif
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection