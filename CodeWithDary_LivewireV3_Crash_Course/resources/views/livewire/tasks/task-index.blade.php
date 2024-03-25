<div>
    <div class="text-center pb-10">
        <input
            type="text"
            class="rounded-md w-1/5 border-0 py-2 text-gray-900 placeholder:text-gray-400 sm:text-sm sm:leading-6"
            wire:model="name"
        />
        <span class="absolute -ml-6 mt-2">
            <span x-text="$wire.name.length"></span>
        </span>
        <x-button :button="$button" />
    </div>
    @foreach ($tasks as $task)
        <x-task-item :task="$task" />
    @endforeach
</div>
