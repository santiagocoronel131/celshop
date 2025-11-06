@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Producto</h1>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
    <label for="image_urls">URLs de las Imágenes (una por línea)</label>
    <textarea name="image_urls" id="image_urls" class="form-control" rows="5">@if(isset($product)){{ $product->images->pluck('image_url')->implode("\n") }}@endif</textarea>
    <small class="form-text text-muted">Pega aquí las URLs de todas las imágenes que quieras mostrar, una en cada línea. La primera será la imagen principal.</small>
</div>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
        </form>
    </div>
@endsection