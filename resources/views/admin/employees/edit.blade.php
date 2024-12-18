@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <div class="d-flex flex-row justify-content-between">
        <h1 class="font-weight-bold">EDITAR EMPLEADO</h1>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i>
            VOLVER</a>
    </div>
@stop

@section('content')

    @livewire('employees.form-edit', ['employee' => $employee])

@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')
    <style>
        .div-disabled {
            pointer-events: none;
            opacity: 0.7;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
@stop
