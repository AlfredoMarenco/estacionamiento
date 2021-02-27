<div class="mt-5">
    @switch($accion)
        @case('escanear')
        <h1 class="text-3xl text-gray-700">Escaner de tickets</h1>
        <label class="block mb-2" for="time_start">Escanea el codigo aqui</label>
        <input class="form-inputs text-center" type="text" wire:model="barcode" wire:keydown.enter="getValue">
        <button class="bg-green-600 mt-5 py-2 w-full rounded-lg text-white font-bold"
            wire:click="getValue">Escanear</button>
        <br>

        <div class="mt-4" wire:loading wire:target="getValue">
            Calculando cantidad...
        </div>
        @break
        @case('cobrar')
        <div class="fixed z-10 inset-0 overflow-y-auto">
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
                                <div class="grid grid-cols-2 justify-items-end">
                                    <h1 class="text-3xl">Total</h1>
                                    <h1 class="text-5xl">${{ number_format($subTotal, 2) }}</h1>
                                    <p>Placa:</p>
                                    <p>{{ $plate }}</p>
                                    <p>Ingreso: </p>
                                    <p>{{ $datetime_start }}</p>
                                    <p>Salida: </p>
                                    <p>{{ $datetime_end }}</p>
                                    <p>{{ intval($diff) }} horas - {{ intval(($diff - intval($diff)) * 60) }}
                                        minutos</p>
                                </div>
                                <label class="block mb-2" for="time_start">Cantidad recibida</label>
                                <input  wire:keydown.enter="cobrar" class="form-inputs text-center" type="text" wire:model="cambio" placeholder="$0.0" autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="cobrar" type="button"
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
        @case('invalido')
        <div class="fixed z-10 inset-0 overflow-y-auto">
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
                                    Operacion no valida
                                </h3>
                                <div class="grid grid-cols-1 justify-items-center">
                                    <h1 class="text-3xl">Cantidad no valida para calcular el cambio</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="regresar" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Regresar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @break
        @case('pagado')
        <div class="fixed z-10 inset-0 overflow-y-auto">
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
                                    Ticket no valido
                                </h3>
                                <div class="grid grid-cols-1 justify-items-center">
                                    <h1 class="text-3xl">Este ticket ya fue escaneado el {{ $datetime_end }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="regresar" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Regresar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @break
        @case('cancelado')
        <div class="fixed z-10 inset-0 overflow-y-auto">
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
                                    Ticket no valido
                                </h3>
                                <div class="grid grid-cols-1 justify-items-center">
                                    <h1 class="text-3xl">Este boleto esta cancelado el dia {{ $datetime_end }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="regresar" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Regresar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @break
    @endswitch
</div>
