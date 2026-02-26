<?php

namespace App\Services;

use App\Models\Product;

class ProductSearchService
{
    public function search(array $filters)
    {
        $query = Product::query()->with(['category', 'tags']);

        // Full-text search on name and description
        if (!empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                  ->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        // Filter by category slug
        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        // Filter by tag slug
        if (!empty($filters['tag'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->where('slug', $filters['tag']);
            });
        }

        // Price range
        if (!empty($filters['price_min']) && is_numeric($filters['price_min'])) {
            $query->where('price', '>=', (float) $filters['price_min']);
        }

        if (!empty($filters['price_max']) && is_numeric($filters['price_max'])) {
            $query->where('price', '<=', (float) $filters['price_max']);
        }

        // Sorting
        switch ($filters['sort'] ?? 'newest') {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default: // newest
                $query->latest();
                break;
        }

        return $query->paginate(12)->withQueryString();
    }
}
