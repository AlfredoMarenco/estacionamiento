<div>
    <div class="flex items-center justify-center p-5">
        <label class="mx-3" for="">De</label>
        <input wire:model="datetime_start" value="datetime_start" class="mx-3 form-inputs" type="datetime-local"
            placeholder="Fecha inicial">
        <label class="mx-3" for="">a</label>
        <input wire:model="datetime_end" value="datetime_end" class="mx-3 form-inputs" type="datetime-local"
            placeholder="Fecha final">
        <button wire:click="toDay" class="w-1/2 bg-gray-300 p-2 rounded-md">Hoy</button>
    </div>
    <div>
        <button wire:click="printCut" class="button-green">Imprimir Corte</button>
    </div>
</div>
