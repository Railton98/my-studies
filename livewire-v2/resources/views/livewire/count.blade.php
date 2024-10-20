<div>
    <h1>Livewire Count Component</h1>

    <div>
        <x-text-input wire:model="name"/>
        <x-primary-button wire:click="toggle('UPPER')">UPPER</x-primary-button>
        <x-primary-button wire:click="toggle('LOWER')">LOWER</x-primary-button>
    </div>
    {{$name}}
</div>
