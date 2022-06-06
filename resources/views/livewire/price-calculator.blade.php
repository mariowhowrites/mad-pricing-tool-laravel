<div class="flex flex-col">
    <h2 class="text-4xl mb-4">MadStickers Price Calculator</h2>


    <div class="flex flex-col lg:flex-row gap-4 max-w-full">
        <label class="flex flex-col">
            Width
            <input type="number" wire:model="width" inputmode="decimal" step="0.25" class="h-24 text-black text-2xl px-4">
        </label>
        <label class="flex flex-col">
            Height
            <input type="number" wire:model="height" inputmode="decimal" step="0.25" class="h-24 text-black text-2xl px-4">
        </label>
        <label class="flex flex-col">
            Quantity
            <input type="number" wire:model="quantity" step="1" class="h-24 text-black text-2xl px-4">
        </label>
    </div>

    <h2>Your Prices</h2>
    <ul>
        @foreach($this->variantPrices as $variant => $price)
            <li>{{ $variant }}: ${{ $price }}</li>
        @endforeach
    </ul>
</div>
