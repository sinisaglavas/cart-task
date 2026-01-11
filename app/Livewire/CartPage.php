<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class CartPage extends Component
{
    public function increase(int $itemId): void
    {
        $item = CartItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->with('product')
            ->firstOrFail();

        if ($item->quantity < $item->product->stock_quantity) {
            $item->increment('quantity');
        }
    }

    public function decrease(int $itemId): void
    {
        $item = CartItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($item->quantity > 1) {
            $item->decrement('quantity');
        }
    }

    public function remove(int $itemId): void
    {
        CartItem::where('id', $itemId)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function getTotalProperty(): float
    {
        return CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get()
            ->sum(fn ($item) => $item->quantity * $item->product->price);
    }

    public function render()
    {
        return view('livewire.cart-page', [
            'items' => CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get(),
        ]);
    }
}

