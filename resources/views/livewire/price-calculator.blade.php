<div class="flex flex-col">
    <h2 class="text-4xl mb-4">MadStickers Price Calculator</h2>


    <div class="flex flex-col lg:flex-row gap-4 max-w-full">
        <label class="flex flex-col">
            Width
            <input type="number" wire:model.debounce.500ms="width" inputmode="decimal" step="0.25" class="h-24 text-black text-2xl px-4">
            @error('width') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col">
            Height
            <input type="number" wire:model.debounce.500ms="height" inputmode="decimal" step="0.25" class="h-24 text-black text-2xl px-4">
            @error('height') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </label>
        <label class="flex flex-col">
            Quantity
            <input type="number" wire:model.debounce.500ms="quantity" step="50" class="h-24 text-black text-2xl px-4">
            @error('quantity') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </label>
    </div>

    <h2 class="text-3xl my-2">Your Prices</h2>
    <ul class="list-disc list-inside">
        @foreach($this->variantPrices as $variant => $price)
            <li>{{ $this->formatKey($variant) }}: ${{ $price }}</li>
        @endforeach
    </ul>

    <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-3 rounded-lg shadow-md hover:shadow-lg" wire:click="addToCart">Add to Cart</button>

    {{-- <h2>Testing</h2>
    <ul>
        <li>Square Inches: {{ $this->squareInches }}</li>
        <li>Closest Measurement: {{ dump($this->closestMeasurementID) }}</li>
        <li>Closest Distance: {{ dump($this->closestDistance) }}</li>
        <li>Results: {{ dump($this->results) }}</li>
    </ul> --}}
</div>
