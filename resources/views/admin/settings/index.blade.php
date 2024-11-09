@extends('adminlte::page')

@section('title', 'Planillas - UGEL')

@section('content_header')
    <div class="d-flex flex-row justify-content-between">
        <h1 class="font-weight-bold">PARÁMETROS</h1>
    </div>
@stop

@section('content')

    @livewire('settings.form')

@stop

@section('footer')
    <p class="text-center">UGEL - ASUNCIÓN</p>
@stop

@section('css')

@stop

@section('js')
    <script src="{{ asset('js/admin/message_forms.js') }}"></script>
@stop
