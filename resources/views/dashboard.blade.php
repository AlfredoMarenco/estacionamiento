<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creador de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center shadow-xl my-2 mx-2 p-3 border rounded-xl">
                        
                        @livewire('form-create-tickets')
                    </div>

                    <div class="text-center shadow-xl my-2 mx-2 p-3 border rounded-xl">

                        @livewire('scaner-tickets')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
