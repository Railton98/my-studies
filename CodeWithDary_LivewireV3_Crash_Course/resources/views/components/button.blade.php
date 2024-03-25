<button
    class="rounded-md bg-pink-600 px-4 py-3 text-sm font-semibold text-white shadow-md hover:bg-pink-500"
    type="submit"
    {{-- wire:click="{{ $click }}"
    wire:confirm="Are you sure you want to add this task?" --}}
>
    {{ $button }}
</button>

<div wire:loading>
    <x-spinner />
</div>
