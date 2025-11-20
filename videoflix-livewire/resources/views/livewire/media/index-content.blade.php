<div>
    <h2 class="mb-10 text-2xl font-bold">Conteúdos</h2>

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

                        <livewire:media.remove-content :content="$content->id" :key="$content->id"
                            @content_removed_{{ $content->id }}="$refresh" />
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
