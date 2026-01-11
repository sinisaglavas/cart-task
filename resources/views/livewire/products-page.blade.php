<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="border rounded-lg p-4 shadow-sm">
                <h2 class="font-semibold text-lg">{{ $product->name }}</h2>

                <p class="mt-2 text-gray-700">
                    Price: <strong>${{ number_format($product->price, 2) }}</strong>
                </p>

                <p class="text-sm text-gray-500">
                    Stock: {{ $product->stock_quantity }}
                </p>

                @auth
                    <button
                        wire:click="addToCart({{ $product->id }})"
                        class="mt-4 px-4 py-2 bg-blue-600 text-black rounded
                               hover:bg-blue-700 disabled:opacity-50"
                        @if ($product->stock_quantity === 0) disabled @endif>
                        Add to cart
                    </button>
                @else
                    <p class="mt-4 text-sm text-gray-400">
                        Login to add products to cart
                    </p>
                @endauth
            </div>
        @endforeach
    </div>
</div>

