<form wire:submit="submit" class="flex">
    <div>
        <x-text-input placeholder="User Name" wire:model.blur="form.name"/>
        <x-input-error :messages="$errors->get('form.name')" class="mt-2"/>
        <div wire:dirty wire:target="form.name" class="text-sm italic font-semibold text-yellow-400">Alterou e não salvou hein...</div>
    </div>
    <div>
        <x-text-input placeholder="User E-mail" type="email" wire:model.blur="form.email"/>
        <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
    </div>
    <div>
        <x-text-input placeholder="User Password" type="password" wire:model.blur="form.password"/>
        <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
    </div>
    <div>
        <x-text-input placeholder="Password Confirmation" type="password" wire:model.blur="form.password_confirmation"/>
    </div>

    <x-primary-button>Update User</x-primary-button>
</form>
