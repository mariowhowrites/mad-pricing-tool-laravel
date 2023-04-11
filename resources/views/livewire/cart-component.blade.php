<div class="w-full min-w-6xl">
    <section id="cart-table" class="border-w border flex flex-col w-3/5 mx-auto bg-white text-black">
        @if (count($cart->batches) == 0)
        <div class="py-4 px-2">No items yet!
            <a href="{{ route('product.show', ['product' => 'stickers']) }}">Go to the store</a>
        </div>
        @endif

        @foreach ($cart->batches as $index => $batch)
        <div class="{{ $this->batchContainerClasses($batch, $index) }}">
            <div class="rounded-lg overflow-hidden">
                <img src="{{ $batch->getTemporaryAssetURL() }}" alt="" class="h-32 w-32 object-contain">
            </div>
            <div class="flex justify-center items-center">
                {{ $batch->variant }}: {{ $batch->width }}" x {{ $batch->height }}" x {{ $batch->quantity }}
            </div>
            <div class="flex items-center justify-between space-x-8">
                <span>${{ $batch->price_in_dollars }}</span>
                <span>
                    <button class="text-red-600 hover:text-red-500 font-bold" wire:click="deleteBatch({{ $batch }})">
                        X
                    </button>
                </span>
            </div>
        </div>
        @endforeach
    </section>

    <p>Cart total ${{ $this->cart->price_in_dollars }}</p>

    @error('stripe')
    <p class="text-red-600">{{ $message }}</p>
    @enderror
    <button wire:click="checkout">Checkout</button>
</div>