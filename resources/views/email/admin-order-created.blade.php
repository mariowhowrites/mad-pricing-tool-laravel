<p>A new order has been placed on MadStickers.com.</p>

<p>All customer assets are attached.</p>

Order details:

<p>Order ID: {{ $order->id }}</p>

<p>Order date: {{ $order->created_at }}</p>

Batches:

<ol>
    @foreach($order->batches as $batch)
        <li>{{ $batch->id }}: {{ $batch->variant }} {{ $batch->width }} x {{ $batch-> width }}, {{ $batch->quantity }}ct</li>
    @endforeach
</ol>

Customer information:

<p>{{ $order->address->name }}</p>

<p>{{ $order->customer_email }}</p>

<p>{{ $order->address->line1 }}</p>

@if($order->address->line2)
<p>{{ $order->address->line2 }}</p>
@endif

<p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}</p>

<p>{{ $order->address->country }}</p>
