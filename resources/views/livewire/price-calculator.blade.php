<div class="flex flex-col space-y-8">
    <div class="flex flex-col gap-4 max-w-full">
        <h2 class="text-3xl font-serif uppercase">Measurements</h2>
        <div class="flex flex-col self-start">
            <label for="width" class="">
                Width
            </label>
            <input type="number" name="width" wire:model.debounce.500ms="width" inputmode="decimal" step="0.25"
                class="h-24 text-black text-2xl px-4">
            @error('width') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col self-start">
            <label for="height" class="">
                Height
            </label>
            <input type="number" name="height" wire:model.debounce.500ms="height" inputmode="decimal" step="0.25"
                class="h-24 text-black text-2xl px-4">
            @error('height') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col self-start">
            <label for="quantity" class="">
                Quantity
            </label>
            <input type="number" name="quantity" wire:model.debounce.500ms="quantity" step="50" class="h-24 text-black text-2xl px-4">
            @error('quantity') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
    </div>

    <form class="flex flex-col space-y-2" wire:submit.prevent="goToImageUpload">
        <h2 class="text-3xl font-serif uppercase">Prices</h2>
        <h2 class="text-3xl font-serif uppercase">${{ $this->variantPrice }}</h2>
        

        @if (strlen($this->variant) > 0 && $errors->isEmpty())
        <button
            class="hover:bg-red-700 hover:text-white px-2 py-3 border border-black hover:border-transparent shadow-md hover:shadow-lg self-start uppercase">Add
            to Cart</button>
        @endif
    </form>


    {{-- <h2>Testing</h2>
    <ul>
        <li>Square Inches: {{ $this->squareInches }}</li>
        <li>Closest Measurement: {{ dump($this->closestMeasurementID) }}</li>
        <li>Closest Distance: {{ dump($this->closestDistance) }}</li>
        <li>Results: {{ dump($this->results) }}</li>
    </ul> --}}
</div>