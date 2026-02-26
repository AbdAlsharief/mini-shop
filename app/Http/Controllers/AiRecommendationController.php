<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ai\Agents\SalesAssistant;
use App\Models\Product;

class AiRecommendationController extends Controller
{
    public function recommend(Request $request)
    {
        $request->validate([
            'story' => 'required|string|max:1000',
        ]);

        // Run the AI agent
        $answer = (string) (new SalesAssistant)->prompt($request->input('story'));

        // Extract keywords from the story to find matching products for the UI cards
        $keywords = $this->extractKeywords($request->input('story'));

        $products = collect();
        foreach ($keywords as $kw) {
            // Priority 1: Exact matches in Name (higher relevance)
            $nameMatches = Product::where('stock', '>', 0)
                ->where('name', 'like', "%{$kw}%")
                ->take(3)
                ->get(['id', 'name', 'price', 'stock', 'description']);
            $products = $products->merge($nameMatches);

            // Priority 2: Matches in Description (lower relevance, only if we need more)
            if ($products->count() < 4) {
                $descMatches = Product::where('stock', '>', 0)
                    ->where('description', 'like', "%{$kw}%")
                    ->whereNotIn('id', $products->pluck('id'))
                    ->take(2)
                    ->get(['id', 'name', 'price', 'stock', 'description']);
                $products = $products->merge($descMatches);
            }
        }

        // Deduplicate and limit to 4 cards
        $products = $products->unique('id')->take(4)->values();

        // If nothing matched keywords, show top 4 newest
        if ($products->isEmpty()) {
            $products = Product::where('stock', '>', 0)
                ->latest()
                ->take(4)
                ->get(['id', 'name', 'price', 'stock', 'description']);
        }

        return response()->json([
            'answer'   => $answer,
            'products' => $products->map(fn ($p) => [
                'id'          => $p->id,
                'name'        => $p->name,
                'price'       => number_format($p->price, 2),
                'description' => $p->description ? \Str::limit($p->description, 80) : null,
                'url'         => route('products.show', $p->id),
                'cart_url'    => route('cart.add', $p->id),
            ]),
        ]);
    }

    private function extractKeywords(string $story): array
    {
        // Strip common stop words and return meaningful single words
        $stop = ['the','a','an','and','or','for','to','in','on','of','my','i','me','who',
                 'is','are','need','want','looking','give','get','buy','find','something',
                 'please','loves','has','like','about','this','that','with','he','she','they',
                 'good','best','some','any','can','you','we','our','your','have','it','its',
                 'very','much','many','really','need','needed','want','wanted','buy','bought'];

        $words = preg_split('/[^\p{L}\p{N}]+/u', strtolower(strip_tags($story)));
        $words = array_filter($words, fn($w) => strlen($w) > 3 && !in_array($w, $stop));
        return array_values(array_unique($words));
    }
}
