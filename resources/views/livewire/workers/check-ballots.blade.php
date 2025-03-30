<div>
    <h1 class="text-2xl font-bold text-center mb-4">CONSULTA BOLETAS DE PAGO</h1>
    <p>Hola, puedes verificar tus boletas de pago seleccionando el mes y el año de interés.</p>
    <form wire:submit='searchEspecificPayment'>
        <select wire:model='month' id="month">
            <option value="">-SELECCIONE-</option>
            @foreach ($months as $index => $month)
                <option value="{{$index}}">{{$month}}</option>
            @endforeach
        </select>
        @error('month')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <select wire:model="year" id="year">
            <option value="">-SELECCIONE-</option>
            @foreach ($years as $year)
                <option value="{{$year}}">{{$year}}</option>
            @endforeach
        </select>
        @error('year')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <button type="submit" class="border p-2 bg-blue-900 text-white"><i class="fa-solid fa-magnifying-glass"></i> BUSCAR</button>
    </form>
    <div class="mt-2">
        @foreach ($payments as $payment)
        <div class="w-full border py-2 px-4 rounded shadow bg-gray-50 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full mb-2">
                <h3 class="text-lg font-semibold">Boleta de pago de {{$months[$payment->mounth]}} del {{$payment->year}}</h3>
                <p>Remuneración bruta: {{$payment->total_remuneration}}</p>
                <p>Remuneración neta: {{$payment->net_pay}}</p>
            </div>
            <div class="my-2 w-full text-center md:text-right">
                <a href="#" class="py-2 px-4 border rounded-md bg-green-700 text-white font-semibold"><i class="fa-solid fa-file-invoice"></i> VER BOLETA</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
