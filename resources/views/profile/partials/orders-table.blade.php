<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Orders') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Check order status or reorder here") }}
        </p>
    </header>

    <div class="overflow-hidden bg-white shadow sm:rounded-md mt-6">
        <ul role="list" class="divide-y divide-gray-200">
            @foreach (Auth::user()->orders as $order)
            <li>
                <a href="{{ route('profile.orders.show', $order) }}" class="block hover:bg-gray-50">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="flex min-w-0 flex-1 items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="">
                            </div>
                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <p class="truncate text-sm font-medium text-indigo-600">Order #{{ $order->id }}</p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500">
                                        <span class="truncate">{{ $order->quantity}}ct, ${{ $order->price_in_dollars }}</span>
                                    </p>
                                </div>
                                <div class="hidden md:block">
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            Ordered on
                                            <time datetime="{{ $order->created_at->toDateString() }}">{{ $order->created_at->toFormattedDateString() }}</time>
                                        </p>
                                        {{-- Order status will go below once implemented --}}
                                        {{-- <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-green-400" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Completed phone screening
                                        </p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</section>