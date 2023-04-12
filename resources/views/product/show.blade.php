<x-layout-component>
    <ul class="space-y-12">
        @foreach ($product->variants as $variant)
        <li>
            <a href="{{ route('variant.show', compact('product', 'variant')) }}">
                <h2 class="text-3xl md:text-6xl hover:text-bold hover:text-red-600 font-serif uppercase">⌾ {{ $variant->name }}</h2>
            </a>
        </li>
        @endforeach
    </ul>
</x-layout-component>