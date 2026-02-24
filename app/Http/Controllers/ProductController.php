<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function addToCart(Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sorry, this product is out of stock.');
        }

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;

        if ($currentQty >= $product->stock) {
            return redirect()->back()->with('error', "Sorry, only {$product->stock} unit(s) available.");
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

        // Always keep stock in sync in case it changed
        $cart[$product->id]['stock'] = $product->stock;

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('products.cart', compact('cart'));    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart');
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $product = Product::find($id);
            $stock = $product ? $product->stock : ($cart[$id]['stock'] ?? PHP_INT_MAX);

            // Clamp quantity between 1 and available stock
            $quantity = max(1, min((int) $request->quantity, $stock));
            $cart[$id]['quantity'] = $quantity;

            // Keep stock fresh
            if ($product) {
                $cart[$id]['stock'] = $product->stock;
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Throwable
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->back();
        }

        return DB::transaction(function () use ($cart) {

            $total = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending'
            ]);

            foreach ($cart as $id => $details) {

                $product = Product::find($id);


                if (!$product) {
                    throw new \Exception("Product not found");
                }

                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }


                $product->decrement('stock', $details['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            session()->forget('cart');

            return redirect('/')->with('success', 'Order placed successfully!');
        });
    }
}
