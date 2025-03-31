<div>
    <h1 class="text-2xl font-bold text-center mb-4">CONSULTA BOLETAS DE PAGO</h1>

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
                        <select wire:model='month' id="month">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($months as $index => $month)
                                <option value="{{ $index }}">{{ $month }}</option>
                            @endforeach
                        </select>
                        @error('month')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <select wire:model="year" id="year">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button type="submit" class="border p-2 bg-blue-900 text-white"><i
                                class="fa-solid fa-magnifying-glass"></i> BUSCAR</button>
                    </form>
                </article>

                <!-- Panel #2 -->
                <article id="tabpanel-2"
                    class="w-full bg-white rounded border p-4 shadow min-[480px]:flex items-stretch focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300"
                    x-show="activeTab === 2"
                    x-transition:enter="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-700 transform order-first"
                    x-transition:enter-start="opacity-0 -translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-[cubic-bezier(0.68,-0.3,0.32,1)] duration-300 transform absolute"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-12">
                    <form wire:submit='searchPaymentsByRange'>
                        <p class="mb-2 mt-0">Seleccione un rango:</p>
                        <span>Desde </span>
                        <select wire:model='month_start' id="month_start">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($months as $index => $month)
                                <option value="{{ $index }}">{{ $month }}</option>
                            @endforeach
                        </select>
                        @error('month_start')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <select wire:model="year_start" id="year_start">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('year_start')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <span> hasta </span>
                        <select wire:model='month_end' id="month_end">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($months as $index => $month)
                                <option value="{{ $index }}">{{ $month }}</option>
                            @endforeach
                        </select>
                        @error('month_end')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <select wire:model="year_end" id="year_end">
                            <option value="">-SELECCIONE-</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('year_end')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button type="submit" class="border p-2 bg-blue-900 text-white"><i
                                class="fa-solid fa-magnifying-glass"></i> BUSCAR</button>
                    </form>
                </article>

            </div>
        </div>

    </div>

    <div class="mt-2">
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
                    <a href="{{ route('check_ballots.payment_slip', $payment->id) }}" target="_blank" class="py-2 px-4 border rounded-md bg-green-700 text-white font-semibold"><i
                            class="fa-solid fa-file-invoice"></i> VER BOLETA</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
