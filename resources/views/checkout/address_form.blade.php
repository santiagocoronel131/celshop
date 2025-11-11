<!-- resources/views/checkout/address_form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Paso 1: Completa tu Domicilio de Entrega</h4></div>
                <div class="card-body">
                    <p class="text-muted">Es tu primera compra. Necesitamos que completes tu domicilio para poder continuar.</p>
                    <form action="{{ route('checkout.address.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Dirección (Calle y Número)</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ciudad</label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Provincia</label>
                                <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" required>
                                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Código Postal</label>
                                <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code') }}" required>
                                @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tipo de Domicilio</label>
                                <select name="address_type" class="form-control">
                                    <option value="hogar">Hogar</option>
                                    <option value="laboral">Laboral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Departamento (Opcional)</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department') }}">
                        </div>
                        <div class="form-group">
                            <label>Indicaciones para la Entrega (Opcional)</label>
                            <textarea name="delivery_instructions" class="form-control">{{ old('delivery_instructions') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Guardar Dirección y Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection