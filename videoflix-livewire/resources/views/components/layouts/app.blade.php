<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        <x-message />
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
