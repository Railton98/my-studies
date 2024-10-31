<div>
    <ul>
        @foreach($this->users as $user)
            <li>{{$user->name}} | {{$user->email}}</li>
        @endforeach
    </ul>

    {{$this->users->links()}}
</div>
