<form wire:submit="calculate">
    <x-text-input placeholder="primeiro número" wire:model="num1"/>
    <select class="text-slate-700" wire:model="operator">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <x-text-input placeholder="segundo número" wire:model="num2"/>
    <x-primary-button>Calcular</x-primary-button>

    <br>
    Resultado: {{$result}}
</form>
