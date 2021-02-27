<div class="mt-5">
    <h1 class="text-3xl text-gray-700">Ingreso de vehiculos</h1>
        <p class="text-gray-100 bg-red-700 rounded-md text-md font-bold">{{ $mensaje }}</p>
    <div class="form-group">
        <label class="block mb-2" for="">Placa del vehículo</label>
        <input class="form-inputs text-center uppercase" type="text" placeholder="XXX-123" wire:model="plate">
    </div>
    <button wire:click="create" class="bg-green-600 mt-5 py-2 w-full rounded-lg text-white font-bold">
        Crear ticket</button>

    <div class="mt-4" wire:loading wire:target="create">
            <svg class="animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Printing
    </div>
</div>
