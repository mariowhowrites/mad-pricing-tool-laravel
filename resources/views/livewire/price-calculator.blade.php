<div class="flex flex-col">
    <select wire:model="selectedURL">
        @foreach ($allURLs as $url)
            <option value="{{ $url }}">{{ $url }}</option>
        @endforeach
    </select>

    <input type="number" wire:model="width" inputmode="decimal" step="0.25">
    <input type="number" wire:model="height" inputmode="decimal" step="0.25">
    <input type="number" wire:model="quantity" step="1">
</div>
