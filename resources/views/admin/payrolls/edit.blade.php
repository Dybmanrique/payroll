@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <div class="d-flex flex-row justify-content-between">
        <h1 class="font-weight-bold">EDITAR PLANILLA</h1>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i>
            VOLVER</a>
    </div>
@stop

@section('content')

    @livewire('payrolls.form-edit', ['payroll' => $payroll])

@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')
    <style>
        .opacity-low {
            opacity: 0.1;
        }

        .opacity-full {
            opacity: 1;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
@stop
