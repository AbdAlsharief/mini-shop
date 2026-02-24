<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        foreach ($users as $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0,
                'status' => fake()->randomElement(['pending', 'completed']),
            ]);

            $total = 0;
            $itemCount = rand(1, 3);

            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price * $quantity;
            }

            $order->update(['total' => $total]);
        }
    }
}
