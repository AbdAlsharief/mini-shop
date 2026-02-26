<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    // ── Cart ────────────────────────────────────────────────────────────────

    public function get(): array
    {
        return session()->get('cart', []);
    }

    public function add(Product $product): string
    {
        if ($product->stock <= 0) {
            return 'error:Sorry, this product is out of stock.';
        }

        $cart       = $this->get();
        $currentQty = $cart[$product->id]['quantity'] ?? 0;

        if ($currentQty >= $product->stock) {
            return "error:Sorry, only {$product->stock} unit(s) available.";
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'stock'    => $product->stock,
            ];
        }

        // Keep stock in sync
        $cart[$product->id]['stock'] = $product->stock;

        session()->put('cart', $cart);

        return 'success:Product added to cart successfully!';
    }

    public function remove(Product $product): void
    {
        $cart = $this->get();

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
    }

    public function update(int $id, int $quantity): void
    {
        $cart = $this->get();

        if (!isset($cart[$id])) {
            return;
        }

        $product  = Product::find($id);
        $stock    = $product?->stock ?? ($cart[$id]['stock'] ?? PHP_INT_MAX);
        $quantity = max(1, min($quantity, $stock));

        $cart[$id]['quantity'] = $quantity;

        if ($product) {
            $cart[$id]['stock'] = $product->stock;
        }

        session()->put('cart', $cart);
    }

    // ── Checkout ────────────────────────────────────────────────────────────

    /**
     * @throws \Throwable
     */
    public function checkout(): void
    {
        $cart = $this->get();

        DB::transaction(function () use ($cart) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total'   => $total,
                'status'  => 'pending',
            ]);

            foreach ($cart as $id => $details) {
                $product = Product::findOrFail($id);

                if ($product->stock < $details['quantity']) {
                    throw new \RuntimeException("Not enough stock for {$product->name}");
                }

                $product->decrement('stock', $details['quantity']);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['price'],
                ]);
            }

            session()->forget('cart');
        });
    }
}
