@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Columna del Carrusel de Imágenes -->
        <div class="col-md-6">
            @if($product->images->isNotEmpty())
                <div id="productCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($product->images as $key => $image)
                            <li data-target="#productCarousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner shadow-sm rounded">
                        @foreach($product->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ $image->image_url }}" class="d-block w-100" alt="Vista {{ $key + 1 }} de {{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            @else
                <!-- Fallback si no hay imágenes múltiples -->
                <img src="{{ $product->image_url ?: asset('img/placeholder.png') }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
            @endif
        </div>

        <!-- Columna de Información del Producto -->
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">Categoría: {{ $product->category->name ?? 'Sin Categoría' }}</p>
            <h3 class="font-weight-bold my-3">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>
            <p><strong>Stock disponible:</strong> {{ $product->stock }}</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg">Agregar al Carrito</button>
            </form>
        </div>
    </div>
</div>
@endsection