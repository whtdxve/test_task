<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Запрос
        $query = Product::query();

        // Фильтрация
        $filters = [
            'q' => fn($query, $value) => $query->where('name', 'LIKE', "%$value%"),
            'price_from' => fn($query, $value) => $query->where('price', '>=', $value),
            'price_to' => fn($query, $value) => $query->where('price', '<=', $value),
            'category_id' => fn($query, $value) => $query->where('category_id', $value),
            'in_stock' => fn($query, $value) => $query->where('in_stock', filter_var($value, FILTER_VALIDATE_BOOLEAN)),
            'rating_from' => fn($query, $value) => $query->where('rating', '>=', $value),
        ];

        foreach ($filters as $filter => $function) {
            if ($request->filled($filter)) {
                $function($query, $request->query($filter));
            }
        }

        // Сортировка
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
            }
        }

        return new ProductCollection($query->paginate(20));
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
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
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
    public function update(UpdateProductRequest $request, Product $product)
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
}
