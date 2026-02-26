<?php

namespace App\Http\Ai\Tools;

use App\Models\Product;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ProductSearchTool implements Tool
{

    public function description(): Stringable|string
    {
        return 'Search the Mini-Shop store for products based on a brief description or keywords provided by the user.';
    }


    public function handle(Request $request): Stringable|string
    {

        $query = $request['search_query'];

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'price', 'description']);

        return $products->toJson();
    }

    public function schema(JsonSchema $schema): array
    {
        return [

            'search_query' => $schema->string()
                ->description('The keyword or phrase to search for in products')
                ->required(),
        ];
    }
}
