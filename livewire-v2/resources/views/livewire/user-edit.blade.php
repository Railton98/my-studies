<div>
    <x-secondary-button wire:click="$set('show', true)">
        Editar
    </x-secondary-button>
    {{ $show ? 'show' : 'nada' }}
    <x-modal name="confirm-user-deletion" :show="$show" focusable>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-danger-button class="ml-3" wire:click="edit">
                {{ __('Confirm') }}
            </x-danger-button>
        </div>
    </x-modal>
</div>
