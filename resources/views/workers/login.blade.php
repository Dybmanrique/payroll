@extends('layouts.guest-worker')

@section('title', 'PLANILLAS UGEL')

@section('content')
    <div class="py-12 px-2">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row items-center p-6 py-2 mb-2 rounded-md bg-white shadow-sm">
                <p><span class="font-semibold">Inicia sesión</span> para consultar las <span class="font-semibold">boletas de tus pagos.</span></p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-md mb-2">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('workers.login') }}">
                        @csrf
                        <!-- Identity type -->
                        <div>
                            <x-input-label for="identity_type_id" :value="__('Tipo identificación')" />
                            {{-- <x-text-input id="identity_type_id" class="block mt-1 w-full" type="text" name="identity_type_id"
                                :value="old('identity_type_id')" required autofocus autocomplete="identity_type_id" /> --}}
                            <select name="identity_type_id" id="identity_type_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($identity_types as $identity_type)
                                    <option value="{{$identity_type->id}}" {{old('identity_type_id') == $identity_type->id ? 'selected' : ''}}>{{$identity_type->name}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('identity_type_id')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="identity_number" :value="__('N° identificación')" />
                            <x-text-input id="identity_number" class="block mt-1 w-full" type="text" name="identity_number"
                                :value="old('identity_number')" required autofocus autocomplete="identity_number" />
                            <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-row items-center p-6 py-2 mb-2 rounded-md bg-white shadow-sm">
                <p>Si tienes problemas para acceder, comunícate al siguiente correo <span class="font-semibold">planillas@ugelasuncion.gob.pe</span>, como también puede acercarce a las oficinas de UGEL Asunción.</p>
            </div>

        </div>
    </div>


@endsection
