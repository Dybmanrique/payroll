@extends('layouts.guest-worker')

@section('title', 'PLANILLAS UGEL')

@section('content')

    <div class="py-12 px-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-md">
                <div class="p-6 text-gray-900">
                    @livewire('workers.check-ballots')
                </div>
            </div>
        </div>
    </div>
@endsection
