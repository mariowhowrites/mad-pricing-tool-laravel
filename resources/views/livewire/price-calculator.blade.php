<div class="flex flex-col space-y-8">
    <div class="flex flex-col lg:flex-row gap-4 max-w-full">
        <div class="flex flex-col">
            <label for="width" class="uppercase font-serif">
                Width
            </label>
            <input type="number" name="width" wire:model.debounce.500ms="width" inputmode="decimal" step="0.25"
                class="h-24 text-black text-2xl px-4">
            @error('width') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col">
            <label for="height" class="uppercase font-serif">
                Height
            </label>
            <input type="number" name="height" wire:model.debounce.500ms="height" inputmode="decimal" step="0.25"
                class="h-24 text-black text-2xl px-4">
            @error('height') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
        <div class="flex flex-col">
            <label for="quantity" class="uppercase font-serif">
                Quantity
            </label>
            <input type="number" name="quantity" wire:model.debounce.500ms="quantity" step="50" class="h-24 text-black text-2xl px-4">
            @error('quantity') <span class="text-black mt-1 font-bold">{{ $message }}</span> @enderror
        </div>
    </div>

    <form class="flex flex-col space-y-2" wire:submit.prevent="goToImageUpload">
        <h2 class="text-xl font-serif uppercase">Your Prices</h2>
        @foreach($this->variantPrices as $variant => $price)
        <div class="">
            <input type="radio" value="{{ $variant }}" name="variant" wire:model="variant">
            <label for="{{ $variant }}">{{ $variant }}: ${{ $price }}</label>
        </div>
        @endforeach

        @if (strlen($this->variant) > 0 && $errors->isEmpty())
        <button
            class="bg-red-500 hover:bg-red-700 text-white px-2 py-3 rounded-lg shadow-md hover:shadow-lg self-start">Add
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