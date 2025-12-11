<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    public function index() {
        $products = Product::latest()->paginate(3);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store() {
        $validated = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $product = Product::create($validated);

        if(request()->hasFile('images')){
            foreach(request()->file('images') as $file){
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Товар создан с изображениями!');
    }


    public function show($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.show', compact('product', 'categories'));
    }

    public function edit($id) {
        $categories = Category::all();
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update($id) {
        $validated = request()->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'main_image' => 'nullable|integer',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $product = Product::findOrFail($id);

        $product->update($validated);

        if (!empty($validated['delete_images'])) {
            foreach ($validated['delete_images'] as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    \Storage::delete($image->path);
                    $image->delete();
                }
            }
        }

        if (!empty($validated['main_image'])) {
            $product->images()->update(['is_main' => false]);

            $mainImage = $product->images()->find($validated['main_image']);
            if ($mainImage) {
                $mainImage->update(['is_main' => true]);
            }
        }

        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'is_main' => false,
                ]);
            }
        }

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Запись успешно обновлена!');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}
