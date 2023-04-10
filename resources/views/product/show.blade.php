<x-layout-component>
    <div class="space-y-12">
        @foreach ($product->variants as $variant)
        <div>
            <a href="{{ route('variant.show', compact('product', 'variant')) }}">
                <h2 class="text-4xl text-6xl text-bold font-serif uppercase">{{ $variant->name }}</h2>
            </a>
        </div>
        @endforeach
    </div>
</x-layout-component>