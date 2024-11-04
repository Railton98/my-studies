<form wire:submit="calculate">
    <x-text-input placeholder="primeiro número" wire:model="num1"/>
    <select class="text-slate-700" wire:model="operator">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <x-text-input placeholder="segundo número" wire:model="num2"/>
    <x-primary-button type="submit">
        <span wire:loading.class="hidden" wire:target="calculate">Calcular</span>
        <span wire:loading wire:target="calculate">Calculando...</span>
    </x-primary-button>

    <x-secondary-button wire:click="add10('num1')">add 10 num1</x-secondary-button>
    <x-secondary-button wire:click="add10('num2')">add 10 num2</x-secondary-button>

    <br>
    <span
        wire:loading
        wire:target="calculate"
        class="text-blue-500 font-bold italic"
    >
        Calculando... aguenta aí!!!
    </span>

    <br>
    Resultado: {{$result}}

    <hr/>
    <br/>
    <x-text-input
        placeholder="keydown events"
        wire:model="keydown"
        wire:keydown.y="notY"
    />
</form>
