<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

#[Layout('layouts.app')]
class ProductsPage extends Component
{
    public function addToCart(int $productId): void
    {
        if (!Auth::check()) {
            return;
        }

        $product = Product::findOrFail($productId);

        $cartItem = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        if ($cartItem->exists && $cartItem->quantity >= $product->stock_quantity) {
            return;
        }

        $cartItem->quantity = ($cartItem->quantity ?? 0) + 1;
        $cartItem->save();
    }

    public function render()
    {
        return view('livewire.products-page', [
            'products' => Product::orderBy('name')->get(),
        ]);
    }
}
