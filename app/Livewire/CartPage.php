<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Jobs\SendLowStockNotification;
use Illuminate\Support\Facades\DB;
use Throwable;


#[Layout('layouts.app')]
class CartPage extends Component
{
    public function render()
    {
        return view('livewire.cart-page', [
            'items' => CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get(),
        ]);
    }

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

    /**
     * @throws Throwable
     */
    public function checkout(): void
    {
        $userId = Auth::id();

        $cartItems = CartItem::where('user_id', $userId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($cartItems, $userId) {

            $total = $cartItems->sum(
                fn ($item) => $item->quantity * $item->product->price
            );

            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;

                if ($item->quantity > $product->stock_quantity) {
                    throw new \Exception('Not enough stock for ' . $product->name);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price_at_time' => $product->price,
                ]);

                // Decrease stock
                $product->decrement('stock_quantity', $item->quantity);

                // Low stock job
                if ($product->stock_quantity <= config('app.low_stock_threshold')) {
                    SendLowStockNotification::dispatch($product->id);
                }
            }

            // Clear cart
            CartItem::where('user_id', $userId)->delete();
        });

        // Optional redirect / flash
        session()->flash('success', 'Order placed successfully!');
    }

}

