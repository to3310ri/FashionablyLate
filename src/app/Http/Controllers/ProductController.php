<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where(
                'name',
                'like',
                '%' . $request->keyword . '%'
            );
        }

        if ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        }

        if ($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        }

        $products = $query
            ->paginate(6)
            ->withQueryString();

        return view(
            'products.index',
            compact('products')
        );
    }

    public function create()
    {
        $seasons = Season::all();

        return view(
            'products.create',
            compact('seasons')
        );
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $image = $request->file('image');

        $imageName =
            time()
            . '_'
            . $image->getClientOriginalName();

        $image->move(
            public_path('images'),
            $imageName
        );

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'image' => 'images/' . $imageName,
            'description' => $validated['description'],
        ]);

        $seasonIds = Season::whereIn(
            'name',
            $validated['seasons']
        )->pluck('id');

        $product->seasons()->sync($seasonIds);

        return redirect()
            ->route('products.index')
            ->with('success', '商品を登録しました');
    }

    public function show(Product $product)
    {
        $product->load('seasons');

        return view(
            'products.show',
            compact('product')
        );
    }

    public function update(
        ProductRequest $request,
        Product $product
    ) {
        $validated = $request->validated();

        $productData = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName =
                time()
                . '_'
                . $image->getClientOriginalName();

            $image->move(
                public_path('images'),
                $imageName
            );

            $productData['image'] = 'images/' . $imageName;
        }

        $product->update($productData);

        $seasonIds = Season::whereIn(
            'name',
            $validated['seasons']
        )->pluck('id');

        $product->seasons()->sync($seasonIds);

        return redirect()
            ->route('products.show', $product)
            ->with('success', '商品情報を更新しました');
    }

    public function destroy(Product $product)
    {
        $product->seasons()->detach();

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '商品を削除しました');
    }
}