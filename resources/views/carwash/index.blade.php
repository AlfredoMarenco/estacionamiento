<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creador de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="w-full">
                    <div class="text-center shadow-xl my-2 mx-2 p-3 border rounded-xl">
                        @livewire('car-wash-from')
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
