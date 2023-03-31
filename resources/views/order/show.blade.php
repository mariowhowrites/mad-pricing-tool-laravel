<x-app-layout>
    <div class="bg-white py-12 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('profile.edit') }}" class="text-gray-400">Back to profile</a>
            </div>
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Order #{{ $order->id }} -- {{
                    $order->quantity }}ct @ ${{ $order->priceInDollars }}</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">Ordered on {{
                    $order->created_at->toFormattedDateString() }}</p>
            </div>
            <ul role="list"
                class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($order->batches as $index => $batch)
                <li>
                    <img class="aspect-[3/2] w-full rounded-2xl object-contain"
                        src="{{ $batch->getCustomerAssetURL() }}"
                        alt="">
                    <h3 class="mt-6 text-lg font-semibold leading-8 tracking-tight text-gray-900">Batch {{ $index + 1 }} -- {{ $batch->variant }}</h3>
                    <p class="text-base leading-7 text-gray-600">{{ $batch->quantity }}ct, {{ $batch->width }}" x {{ $batch->height }}"</p>
                </li>
                @endforeach

                <!-- More people... -->
            </ul>
        </div>
    </div>

</x-app-layout>