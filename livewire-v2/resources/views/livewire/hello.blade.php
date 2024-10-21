<div>
    <x-text-input wire:model="text"/>
    @error('text')
    <span class="text-red-400 font-bold font-mono">
        {{$message}}
    </span>
    @enderror

    <div class="text-white">
        {{$user->name}}
    </div>
</div>
