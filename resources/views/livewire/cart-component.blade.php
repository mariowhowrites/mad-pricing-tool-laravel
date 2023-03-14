<div class="w-full">
    <section id="cart-table" class="border-w border flex flex-col w-3/5 mx-auto bg-slate-100 text-black rounded-2xl">
        @if (count($cart->batches) == 0)
            <div class="py-4 px-2">No items yet! Go to the store</div>
        @endif

        @foreach ($cart->batches as $index => $batch)            
        <div class="{{ $this->batchContainerClasses($batch, $index) }}">
            <div>
                {{ $batch->variant }}: {{ $batch->width }}" x {{ $batch->height }}" x {{ $batch->quantity }}
            </div>
            <div class="flex">
                <span>${{ $batch->price_in_dollars }}</span>
                <span>
                    <button wire:click="deleteBatch({{ $batch }})">
                        X
                    </button>
                </span>
            </div>
        </div>
        @endforeach
    </section>

    <p>Cart total ${{ $this->cart->price_in_dollars }}</p>
    

    <button wire:click="checkout">Checkout</button>
</div>