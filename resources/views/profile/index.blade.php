<!-- resources/views/profile/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Columna de la Izquierda: Resumen del Carrito y Datos Actuales -->
        <div class="col-lg-5 mb-4">
            <!-- DATOS ACTUALES DEL USUARIO -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4><i class="fas fa-user-circle mr-2"></i>Mis Datos Actuales</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Teléfono:</strong> {{ $user->phone ?: 'No especificado' }}</li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $user->address ?: 'No especificada' }}</li>
                        <li class="list-group-item"><strong>Ciudad:</strong> {{ $user->city ?: 'No especificada' }}</li>
                        <li class="list-group-item"><strong>Provincia:</strong> {{ $user->province ?: 'No especificada' }}</li>
                    </ul>
                </div>
            </div>

            <!-- RESUMEN DEL CARRITO -->
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-shopping-cart mr-2"></i>Resumen del Carrito</h4>
                </div>
                <div class="card-body">
                    @if (empty($cart))
                        <p class="text-center">Tu carrito está vacío.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-block">Ver Productos</a>
                    @else
                        <table class="table table-sm">
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cart as $id => $item)
                                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                    <tr>
                                        <td>{{ $item['name'] }} <small class="text-muted">x{{ $item['quantity'] }}</small></td>
                                        <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Total:</th>
                                    <th class="text-right">${{ number_format($total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-block">Ver Carrito Completo</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna de la Derecha: Formulario para Editar Datos -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit mr-2"></i>Editar mi Información</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- ESTE ES EL FORMULARIO QUE FALTABA -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH') <!-- Le decimos a Laravel que esto es una actualización -->
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="form-text text-muted">El email no puede ser modificado por seguridad.</small>
                        </div>

                        <hr>
                        <h5>Actualizar Dirección de Envío</h5>

                        <div class="form-group">
                            <label for="address">Dirección (Calle y Número)</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address) }}" required>
                             @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">Ciudad</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $user->city) }}" required>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="province">Provincia</label>
                                <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province', $user->province) }}" required>
                                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection