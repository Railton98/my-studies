<div>
    <h1>Hello from counter!</h1>

    <br>

    Counter:: {{$counter}}
    <br>
    <x-text-input wire:model="counter" />
    <x-primary-button wire:click="refresh">Refresh</x-primary-button>

    <br><br>
    <div x-data="">
        Name in JS:: <span x-text="$wire.name"></span>
        <x-secondary-button @click="$wire.set('name', 'Tecks')">test</x-secondary-button>
    </div>
    <br><br>

    Name:: {{$name}} {{$lastName}}
</div>
