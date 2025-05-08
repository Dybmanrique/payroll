<div>
    <h1 class="text-2xl font-bold text-center mb-4">CONSULTAR BOLETAS DE PAGO</h1>

    <div x-data="{ activeTab: 1 }">

        <!-- Buttons -->
        <div class="flex justify-center">
            <div class="inline-flex flex-wrap justify-center bg-slate-200 rounded-[20px] p-1 mb-3">
                <!-- Button #1 -->
                <button id="tab-1"
                    class="flex-1 text-sm font-medium h-8 px-4 rounded-2xl whitespace-nowrap focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150 ease-in-out"
                    :class="activeTab === 1 ? 'bg-white text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                    @click="activeTab = 1">POR PERIODO</button>
                <!-- Button #2 -->
                <button id="tab-2"
                    class="flex-1 text-sm font-medium h-8 px-4 rounded-2xl whitespace-nowrap focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150 ease-in-out"
                    :class="activeTab === 2 ? 'bg-white text-slate-900' : 'text-slate-600 hover:text-slate-900'"
                    @click="activeTab = 2">POR RANGO</button>
            </div>
        </div>

        <!-- Tab panels -->
        <div class="w-auto mx-auto">
            <div class="relative flex flex-col">

                <!-- Panel #1 -->
                <article id="tabpanel-1"
                    class="w-full bg-white rounded border p-4 shadow  focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300"
                    x-show="activeTab === 1"
                    x-transition:enter="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-700 transform order-first"
                    x-transition:enter-start="opacity-0 -translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-300 transform absolute"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-12">
                    <form wire:submit='searchEspecificPayment'>
                        <p class="mb-2 mt-0">Seleccione un periodo:</p>
                        <div class="flex gap-2 flex-col md:flex-row">

                            <x-select-input id="month" wire:model="month" required>
                                <option value="" class='hidden'>Mes</option>
                                @foreach ($months as $index => $month)
                                    <option value="{{ $index }}">{{ $month }}</option>
                                @endforeach
                            </x-select-input>
                            @error('month')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror

                            <x-select-input id="year" wire:model="year" required>
                                <option value="" class='hidden'>Año</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </x-select-input>
                            @error('year')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror

                            <button type="submit"
                                class="border py-2 px-4 bg-blue-800 text-white rounded-md font-semibold"><i
                                    class="fa-solid fa-magnifying-glass"></i> BUSCAR</button>
                        </div>

                    </form>
                </article>

                <!-- Panel #2 -->
                <article id="tabpanel-2"
                    class="w-full bg-white rounded border p-4 shadow  focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300"
                    x-show="activeTab === 2"
                    x-transition:enter="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-700 transform order-first"
                    x-transition:enter-start="opacity-0 -translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-300 transform absolute"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-12">
                    <form wire:submit='searchPaymentsByRange'>
                        <p class="mb-2 mt-0">Seleccione un rango:</p>
                        <div class="flex flex-col lg:flex-row gap-2">
                            <div class="flex items-normal md:items-center gap-2 flex-col md:flex-row">
                                <span>Desde </span>

                                <x-select-input id="month_start" wire:model="month_start" required>
                                    <option value="" class='hidden'>Mes</option>
                                    @foreach ($months as $index => $month)
                                        <option value="{{ $index }}">{{ $month }}</option>
                                    @endforeach
                                </x-select-input>
                                @error('month_start')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror

                                <x-select-input id="year_start" wire:model="year_start" required>
                                    <option value="" class='hidden'>Año</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </x-select-input>
                                @error('year_start')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items-normal md:items-center gap-2 flex-col md:flex-row">
                                <span> Hasta </span>
                                <x-select-input id="month_end" wire:model="month_end" required>
                                    <option value="" class='hidden'>Mes</option>
                                    @foreach ($months as $index => $month)
                                        <option value="{{ $index }}">{{ $month }}</option>
                                    @endforeach
                                </x-select-input>
                                @error('month_end')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror

                                <x-select-input id="year_end" wire:model="year_end" required>
                                    <option value="" class='hidden'>Año</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </x-select-input>
                                @error('year_end')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                                <button type="submit"
                                    class="border py-2 px-4 bg-blue-800 text-white rounded-md font-semibold"><i
                                        class="fa-solid fa-magnifying-glass"></i> BUSCAR</button>
                            </div>
                            @error('error_extra')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </article>

            </div>
        </div>

    </div>

    <div role="status" class="flex items-center gap-2 mt-1" wire:loading wire:target='searchEspecificPayment, searchPaymentsByRange'>
        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
        <span class="text-gray-600">Cargando...</span>
    </div>

    <div class="mt-4" wire:loading.remove wire:target='searchEspecificPayment, searchPaymentsByRange'>
        @if (count($payments) > 0)
            @foreach ($payments as $payment)
                <div
                    class="w-full border py-2 px-4 rounded shadow bg-gray-50 flex flex-col md:flex-row justify-between items-center">
                    <div class="w-full mb-2">
                        <h3 class="text-lg font-semibold">Boleta de pago de {{ $months[$payment->mounth] }} del
                            {{ $payment->year }}</h3>
                        <p>Remuneración bruta: {{ $payment->total_remuneration }}</p>
                        <p>Remuneración neta: {{ $payment->net_pay }}</p>
                    </div>
                    <div class="my-2 w-full text-center md:text-right">
                        <a href="{{ route('check_ballots.payment_slip', $payment->id) }}" target="_blank"
                            class="py-2 px-4 border rounded-md bg-green-700 text-white font-semibold"><i
                                class="fa-solid fa-file-invoice"></i> VER BOLETA</a>
                    </div>
                </div>
            @endforeach
        @elseif(!empty($payments) && count($payments) <= 0)
            <div class="w-full border py-2 px-4 rounded shadow bg-gray-50 flex flex-col md:flex-row justify-between items-center">
                <p>No se encontraron resultados.</p>
            </div>
        @endif
    </div>
</div>
