<div>
    <ul>
        @foreach($boards as $board)
            <li>{{ $board->name }}</li>
        @endforeach
    </ul>
</div>
