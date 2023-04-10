<x-layout-component>
    <div class="space-y-8">
        <a href="{{ route('retail') }}">
            <h2 class="text-4xl text-9xl text-bold font-serif">MADSTICKERS</h2>
        </a>
        <div id="sticker-carousel" class="flex space-x-6">
            @foreach (range(1, 4) as $item)        
            <img class="h-48 w-48 object-contain" src="/storage/images/sample-sticker-image-{{ $item }}.webp" alt="">
            @endforeach
        </div>
        <div>
            <a href="{{ route('product.show', ['product' => 'stickers'])}}" class="text-2xl text-9xl hover:text-bold hover:text-red-600 font-serif">BUY ➡</a>
        </div>
    </div>
</x-layout-component>