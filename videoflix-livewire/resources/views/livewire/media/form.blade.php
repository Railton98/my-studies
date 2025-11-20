<div>
    @if (request()->routeIs('media.contents.edit'))
        <div class="flex items-center justify-end w-full mb-10">
            <a wire:navigate href="{{ route('media.contents.videos.upload', $contentId) }}"
                class="px-4 py-2 font-bold text-white transition duration-300 ease-in-out bg-green-700 border-green-900 rounded hover:bg-green-900">
                UPLOAD VÍDEOS
            </a>
        </div>
    @endif
    <form wire:submit="save">
        <div class="w-full mb-6">
            <label for="title" class="block mb-2">Titulo</label>
            <input type="text" id="title" wire:model="form.title" class="w-full p-3 border border-gray-400 rounded">

            @error('form.title')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label for="description" class="block mb-2">Descrição</label>
            <input type="text" id="description" wire:model="form.description"
                class="w-full p-3 border border-gray-400 rounded">

            @error('form.description')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label for="body" class="block mb-2">Conteúdo</label>
            <textarea id="body" wire:model="form.body" class="w-full p-3 border border-gray-400 rounded"></textarea>

            @error('form.body')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label for="slug" class="block mb-2">Slug</label>
            <input type="text" id="slug" wire:model="form.slug"
                class="w-full p-3 border border-gray-400 rounded">

            @error('form.slug')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label for="type" class="block mb-2">Tipo</label>

            <select wire:model="form.type" id="type" class="w-full p-3 border border-gray-400 rounded">
                <option value="MOVIE">FILME</option>
                <option value="SERIE">SÉRIE</option>
            </select>

            @error('form.type')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label for="status" class="block mb-2">Status</label>

            <select wire:model="form.status" id="status" class="w-full p-3 border border-gray-400 rounded">
                <option value="ACTIVE">ATIVO</option>
                <option value="DRAFT">RASCUNHO</option>
                <option value="INACTIVE">INATIVO</option>
            </select>

            @error('form.status')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="w-full mb-6" x-data="{
            dropping: false,
            handleCover(event) {
                $wire.upload('form.cover', event.dataTransfer.files[0])
            }
        }">
            <label for="cover" x-on:dragleave.prevent="dropping = false" x-on:dragover.prevent="dropping = true"
                x-on:drop="dropping = false" x-on:drop.prevent="handleCover($event)"
                x-bind:class="{
                    'border-gray-300': !dropping,
                    'border-gray-600': dropping
                }"
                class="flex items-center justify-center p-10 font-bold border-4 border-dashed rounded cursor-pointer dark:text-white bg-zinc-800">
                Clique ou arraste sua imagem para capa do Conteúdo...
            </label>

            <input type="file" id="cover" wire:model="form.cover" class="sr-only">

            @error('form.cover')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror

            @if (!$form->cover && $form->coverReal)
                <img src="{{ asset('storage/' . $form->coverReal) }}" alt="">
            @endif

            @if ($form->cover)
                <img src="{{ $form->cover->temporaryUrl() }}" alt="">
            @endif
        </div>

        <button
            class="px-4 py-2 font-bold text-white transition duration-300 ease-in-out bg-green-700 border-green-900 rounded hover:bg-green-900">
            {{ $labelButton }}
        </button>

        <div wire:loading>
            Processando...
        </div>
    </form>
</div>
