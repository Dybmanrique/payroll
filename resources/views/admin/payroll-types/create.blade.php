@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <div class="d-flex flex-row justify-content-between">
        <h1 class="font-weight-bold">REGISTRAR GRUPO</h1>
        <a href="{{ route('payroll_types.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i>
            VOLVER</a>
    </div>
@stop

@section('content')

    @livewire('payroll-types.form-create')

@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
@stop
