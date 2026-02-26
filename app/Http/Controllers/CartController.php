<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        return view('products.cart', ['cart' => $this->cart->get()]);
    }

    public function add(Product $product): RedirectResponse
    {
        [$type, $message] = explode(':', $this->cart->add($product), 2);

        return redirect()->back()->with($type, $message);
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cart->remove($product);

        return redirect()->back()->with('success', 'Product removed!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->cart->update($id, (int) $request->input('quantity', 1));

        return redirect()->back();
    }

    public function checkout(): RedirectResponse
    {
        if (empty($this->cart->get())) {
            return redirect()->back();
        }

        try {
            $this->cart->checkout();
            return redirect('/')->with('success', 'Order placed successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
