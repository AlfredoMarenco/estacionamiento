<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuracion del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-3 p-3">
                    <form action="{{ route('configuration.update', $configurations->id) }}" method="POST">
                        @csrf

                        <div class="form-group mt-2">
                            <label class="block" for="company">Impresora</label>
                            <select class="appearance-none p-2 w-full block rounded-sm" name="printer">
                                @for ($i = 0; $i < sizeof($impresoras); $i++)
                                    <option value="{{$impresoras[$i]['name']}}" {{ $impresoras[$i]['name'] == $configurations->printer ? 'selected' : '' }}>{{$impresoras[$i]['name']}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label class="block" for="company">Name company</label>
                            <input class="form-inputs" name="company" type="text"
                                value="{{ $configurations->company }}">
                        </div>
                        <div class="form-group mt-2">
                            <label class="block" for="company">Price hours</label>
                            <input class="form-inputs" name="price_hours" type="number"
                                value="{{ $configurations->price_hours }}">
                        </div>
                        <div class="block mt-6 mb-5 text-center w-full">Cost by fraction intervals</div>
                        <div class="grid grid-cols-8 mt-2">
                            <label class="block mx-auto my-auto" for="company">0 to 15 min</label>
                            <input class="form-inputs" name="quarter1" type="number"
                                value="{{ $configurations->quarter1 }}">

                            <label class="block mx-auto my-auto" for="company">16 to 30 min</label>
                            <input class="form-inputs" name="quarter2" type="number"
                                value="{{ $configurations->quarter2 }}">

                            <label class="block mx-auto my-auto" for="company">31 to 45 min</label>
                            <input class="form-inputs" name="quarter3" type="number"
                                value="{{ $configurations->quarter3 }}">

                            <label class="block mx-auto my-auto" for="company">46 to 59 min</label>
                            <input class="form-inputs" name="quarter4" type="number"
                                value="{{ $configurations->quarter4 }}">
                        </div>
                        <div class="form-group mt-2">
                            <label class="block" for="company">Rules</label>
                            <textarea class="form-inputs" name="rules" name="rules" cols="100"
                                rows="10">{{ $configurations->rules }}</textarea>
                        </div>
                        <button type="submit"
                            class="bg-green-600 mt-5 py-2 w-full rounded-lg text-white font-bold">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
