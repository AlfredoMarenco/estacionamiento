<div class="grid grid-cols-3 gap-1">
    <div class="p-3">
        <div class="col-span-2">
            <input wire:model="order" class="bg-gray-200 rounded w-full p-1 text-gray-700 border border-gray-200"
                type="text" placeholder="# Orden">
        </div>
    </div>
    <div class="col-span-2 p-3">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Placa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $ticket->plate }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($ticket->pagado)
                                                @case(0)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange text-gray-100">
                                                    Abierto
                                                </span>
                                                @break
                                                @case(1)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pagado
                                                </span>
                                                @break
                                                @case(2)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Cancelado / reembolsado
                                                </span>
                                                @break
                                                @case(3)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-400 text-gray-800">
                                                    Cancelado / no reembolsado
                                                </span>
                                                @case(4)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-black text-gray-100">
                                                    Ticket Perdido
                                                </span>
                                                @break
                                                @case(5)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-600 text-gray-100">
                                                    Carwash
                                                </span>
                                                @break
                                                @default

                                            @endswitch
                                            @if ($ticket->pagado == 1)

                                            @else

                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            $ {{ number_format($ticket->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('reports.show', $ticket) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
