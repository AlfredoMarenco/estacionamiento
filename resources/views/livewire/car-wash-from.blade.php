<div class="mt-5 w-full">
    @switch($accion)
        @case('placa')
        <h1 class="text-3xl text-gray-700">Carwash</h1>
        <p class="text-gray-100 bg-red-700 rounded-md text-md font-bold">{{ $mensaje }}</p>
        <div class="form-group">
            <label class="block mb-2" for="">Placa del vehículo</label>
            <input class="form-inputs text-center uppercase" type="text" placeholder="XXX-123" wire:model="plate">
        </div>
        <button wire:click="cobrar" class="bg-green-600 mt-5 py-2 w-full rounded-lg text-white font-bold">
            Crear ticket</button>

        <div class="mt-4" wire:loading wire:target="create">
            <svg class="animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Printing
        </div>
        @break
        @case('cobrar')
        <div class="fixed z-10 inset-0 overflow-y-auto text-center">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="text-center">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                    Monto a pagar
                                </h3>
                                <div class="grid grid-cols-1 justify-items-center">
                                    <h1 class="text-3xl">Total</h1>
                                </div>
                                <label class="block mb-2" for="time_start">Costo del lavado</label>
                                <input wire:keydown.enter="cobrar" class="form-inputs text-center" type="text"
                                    wire:model="amount" placeholder="$0.0" autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="create" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Cobrar e imprimir
                        </button>
                        <button wire:click="cancelar" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-red-700 text-base font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @break
        @default

    @endswitch

</div>
