<div>
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm w-2/6 mx-auto text-green-800 rounded-lg bg-green-50">
            <span class="font-medium">
                Sucess Alert
            </span>
            {{ session('message') }}
        </div>
    @endif
</div>
