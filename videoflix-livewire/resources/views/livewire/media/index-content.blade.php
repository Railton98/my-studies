<div>
    @foreach ($contents as $content)
        <li>{{ $content->title }} - {{ $content->status }}</li>
    @endforeach

    {{ $contents->links() }}
</div>
