<div>
    <h1>Livewire Count Component</h1>

    <div>
        <x-text-input wire:model="name"/>
        <x-primary-button wire:click="toggle"/>
    </div>
    {{$name}}
</div>
