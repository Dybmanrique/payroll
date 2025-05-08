@extends('layouts.guest-worker')

@section('title', 'PLANILLAS UGEL')

@section('content')

    <div class="py-12 px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('workers.check-ballots')
        </div>
    </div>
@endsection
