<div>
    <form wire:submit="storeVideos">
        <div class="w-full mb-6" x-data="{
            dropping: false,
            uploading: false,
            progress: 0,
            handleUpload(event) {
                $wire.uploadMultiple('videos', event.dataTransfer.files,
                    (uploadedFilename) => {
                        this.uploading = false;
                    },
                    () => {},
                    (event) => {
                        this.progress = event.detail.progress
                    },
                )
            }
        }" x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <label for="videos" x-on:dragleave.prevent="dropping = false" x-on:dragover.prevent="dropping = true"
                x-on:drop="dropping = false; uploading = true;" x-on:drop.prevent="handleUpload($event)"
                x-bind:class="{
                    'border-gray-300': !dropping,
                    'border-gray-600': dropping
                }"
                class="flex items-center justify-center p-10 font-bold border-4 border-dashed rounded cursor-pointer dark:text-white bg-zinc-800">
                Clique ou arraste seus vídeos para realizar o upload...
            </label>

            <input type="file" id="videos" wire:model="videos" class="sr-only" multiple>

            <!-- Progress Bar -->
            <div x-show="uploading" class="w-full">
                <progress max="100" x-bind:value="progress" class="w-full rounded-xl"></progress>
            </div>
            <!-- Progress Bar -->

            @error('videos.*')
                <div class="p-4 my-4 text-red-900 bg-red-300 border border-red-900 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button
            class="px-4 py-2 font-bold text-white transition duration-300 ease-in-out bg-green-700 border-green-900 rounded hover:bg-green-900">
            Realizar Upload
        </button>
    </form>
</div>
