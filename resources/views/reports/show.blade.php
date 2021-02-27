<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de orden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @switch($ticket->pagado)
                    @case(0)
                    <div class="flex justify-center bg-orange p-3">
                        <h2 class="text-xl text-gray-100 font-bold">Orden: {{ $ticket->id }} | Estatus: No completado | Creada el {{ $ticket->created_at }}
                        </h2>
                    </div>
                    <div class="grid grid-cols-4 gap-3 justify-items-center items-center">
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Placa</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Total</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Ingreso</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Tiempo desde el ingreso
                        </div>
                        <div class="my-6">{{ $ticket->plate }}</div>
                        <div class="my-6">$ {{ number_format($ticket->amount, 2) }}</div>
                        <div class="my-6">{{ $ticket->datetime_start }}</div>
                        <div class="my-6">{{ Carbon\Carbon::parse($ticket->datetime_start)->diffForHumans() }}</div>
                        <div class="col-span-4 text-center my-2 bg-gray-200 w-full">
                            <small>Creada por {{ $ticket->user->name  }}</small>
                        </div>
                        <div class="col-span-4 my-2">
                            <form action="{{ route('ticket.cancel', $ticket) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 p-1 rounded-md text-center text-white font-semibold">Cancelar
                                    Ticket</button>
                            </form>
                        </div>
                    </div>
                    @break
                    @case(1)
                    <div class="flex justify-center bg-green-400 p-3">
                        <h2 class="text-xl text-indigo-700 font-bold">Orden: {{ $ticket->id }} / Estatus: Completado /
                            Total: $ {{ number_format($ticket->amount, 2) }} </h2>
                    </div>
                    <div class="grid grid-cols-4 gap-3 justify-items-center items-center">
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Placa</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Total</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Ingreso</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Salida
                        </div>
                        <div class="my-6">{{ $ticket->plate }}</div>
                        <div class="my-6">$ {{ number_format($ticket->amount, 2) }}</div>
                        <div class="my-6">{{ $ticket->datetime_start }}</div>
                        <div class="my-6">{{ $ticket->datetime_end }}</div>
                        <div class="col-span-4 my-2">
                            <form action="{{ route('printer.reprint', $ticket) }}" method="POST">
                                @method('POST')
                                @csrf
                                <button type="submit"
                                    class="bg-gray-600 p-1 rounded-md text-center text-white font-semibold">Re-imprimir
                                    comprobante</button>
                            </form>
                        </div>
                    </div>
                    @break
                    @case(2)
                    <div class="flex justify-center bg-red-600 p-3">
                        <h2 class="text-xl text-gray-100 font-bold">Orden: {{ $ticket->id }} / Estatus: Cancelada
                        </h2>
                    </div>
                    <div class="grid grid-cols-4 gap-3 justify-items-center items-center">
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Placa</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Total</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Ingreso</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Salida
                        </div>
                        <div class="my-6">{{ $ticket->plate }}</div>
                        <div class="my-6">$ {{ number_format($ticket->amount, 2) }}</div>
                        <div class="my-6">{{ $ticket->datetime_start }}</div>
                        <div class="my-6">{{ $ticket->datetime_end }}</div>
                    </div>
                    @break
                    @case(3)
                    <div class="flex justify-center bg-gray-600 p-3">
                        <h2 class="text-xl text-gray-100 font-bold">Orden: {{ $ticket->id }} / Estatus: Cancelada fuera de tiempo
                        </h2>
                    </div>
                    <div class="grid grid-cols-4 gap-3 justify-items-center items-center">
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Placa</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Total</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Ingreso</div>
                        <div class="bg-gray-800 w-full text-center text-white font-bold rounded-t-md mt-4">Fecha de
                            Salida
                        </div>
                        <div class="my-6">{{ $ticket->plate }}</div>
                        <div class="my-6">$ {{ number_format($ticket->amount, 2) }}</div>
                        <div class="my-6">{{ $ticket->datetime_start }}</div>
                        <div class="my-6">{{ $ticket->datetime_end }}</div>
                    </div>
                    @break
                    @default

                @endswitch
            </div>
        </div>
    </div>
</x-app-layout>
