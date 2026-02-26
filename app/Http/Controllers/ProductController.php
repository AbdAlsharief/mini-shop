<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductsRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Services\ProductSearchService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductSearchService $search) {}

    public function index(SearchProductsRequest $request): View
    {
        return view('products.index', [
            'products'   => $this->search->search($request->filters()),
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function liveSearch(SearchProductsRequest $request): View
    {
        return view('products._results', [
            'products' => $this->search->search($request->filters()),
        ]);
    }
}
