<x-layout-component>
    <div class="space-y-8">
        <h2 class="text-5xl md:text-9xl text-bold font-serif uppercase">Madstickers</h2>

        <div id="sticker-carousel" class="flex flex-wrap space-x-6">
            @foreach (range(1, 4) as $item)        
            <img class="w-16 h-16 md:w-48 md:h-48 object-contain" src="/storage/images/sample-sticker-image-{{ $item }}.webp" alt="">
            @endforeach
        </div>
        
        <div>
            <a href="{{ route('product.show', ['product' => 'stickers'])}}" class="text-5xl md:text-9xl hover:text-bold hover:text-red-600 font-serif uppercase">Buy ➡</a>
        </div>
    </div>
</x-layout-component>