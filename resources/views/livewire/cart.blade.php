<div>
    <ul>
        @foreach ($batches as $batch)
        <p>ID: {{ $batch->id }}. {{ $batch->width }}" x {{ $batch->height }}" x {{ $batch->quantity }}</p>
        @endforeach
    </ul>
</div>