@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Producto</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product" class="form-label">Título</label>
            <input type="text" class="form-control" id="product" name="product" value="{{ old('product', $sale->product) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description', $sale->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio (€)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $sale->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-control" id="category_id" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $sale->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($sale->image)
                <img src="{{ asset('storage/' . $sale->image) }}" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
