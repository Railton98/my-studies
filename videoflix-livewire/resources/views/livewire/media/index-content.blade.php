<div>
    <div class="flex items-center justify-between w-full mb-10">
        <h2 class="mb-10 text-2xl font-bold">Conteúdos</h2>

        <a wire:navigate href="{{ route('media.contents.create') }}"
            class="px-4 py-2 font-bold text-white transition duration-300 ease-in-out bg-green-700 border-green-900 rounded hover:bg-green-900">
            CRIAR CONTEÚDO
        </a>
    </div>

    <table class="w-full">
        <thead>
            <tr>
                <th class="px-6 py-4 text-xl font-bold text-left">#</th>
                <th class="px-6 py-4 text-xl font-bold text-left">Conteúdo</th>
                <th class="px-6 py-4 text-xl font-bold text-left">Status</th>
                <th class="px-6 py-4 text-xl font-bold text-left">Criado em</th>
                <th class="px-6 py-4 text-xl font-bold text-left">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contents as $content)
                <tr class="pb-1 border-b border-gray-400">
                    <td class="px-6 py-4 text-xl text-left">{{ $content->id }}</td>
                    <td class="px-6 py-4 text-xl text-left">{{ $content->title }}</td>
                    <td class="px-6 py-4 text-xl text-left">{{ $content->status }}</td>
                    <td class="px-6 py-4 text-xl text-left">{{ $content->created_at->format('d/m/Y h:i') }}</td>
                    <td class="flex gap-4 px-6 py-4 text-xl text-left">
                        <a wire:navigate href="{{ route('media.contents.edit', $content->id) }}"
                            class="px-4 py-2 font-bold text-white transition duration-300 ease-in-out bg-blue-700 border-blue-900 rounded hover:bg-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <livewire:media.remove-content :contentId="$content->id" :key="$content->id" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sem conteúdos!</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
