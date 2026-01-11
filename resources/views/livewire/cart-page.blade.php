<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    @if ($items->isEmpty())
        <p class="text-gray-500">Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach ($items as $item)
                <div class="flex justify-between items-center border p-4 rounded">
                    <div>
                        <h2 class="font-semibold">{{ $item->product->name }}</h2>
                        <p class="text-sm text-gray-500">
                            ${{ number_format($item->product->price, 2) }}
                        </p>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button
                            wire:click="decrease({{ $item->id }})"
                            class="px-2 py-1 border rounded">−</button>

                        <span>{{ $item->quantity }}</span>

                        <button
                            wire:click="increase({{ $item->id }})"
                            class="px-2 py-1 border rounded"
                        >+</button>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold">
                            ${{ number_format($item->quantity * $item->product->price, 2) }}
                        </p>

                        <button
                            wire:click="remove({{ $item->id }})"
                            class="text-sm text-red-500 hover:underline">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-between items-center">
            <p class="text-xl font-bold">
                Total: ${{ number_format($this->total, 2) }}
            </p>

            <button
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Checkout
            </button>
        </div>
    @endif
</div>

