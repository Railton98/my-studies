<form wire:submit="submit" class="flex">
    <div>
        <x-text-input placeholder="User Name" wire:model.blur="name"/>
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <div>
        <x-text-input placeholder="User E-mail" type="email" wire:model.blur="email"/>
        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
    </div>
    <div>
        <x-text-input placeholder="User Password" type="password" wire:model.blur="password"/>
        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
    </div>
    <div>
        <x-text-input placeholder="Password Confirmation" type="password" wire:model.blur="password_confirmation"/>
    </div>

    <x-primary-button>Save User</x-primary-button>
</form>
