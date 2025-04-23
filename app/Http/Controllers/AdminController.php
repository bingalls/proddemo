<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\ProdRepo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function products(): Factory|View|Application
    {
        $products = Product::all();

        return view('admin.products', compact('products'));
    }

    /**
     * @param int $id
     * @return Factory|View|Application
     */
    public function editProduct(int $id): Factory|View|Application
    {
        $product = Product::find($id);

        return view('admin.edit_product', compact('product'));
    }

    /**
     * @param ProductRequest $request
     * @param array|bool|null|string $id
     * @return RedirectResponse
     */
    public function updateProduct(ProductRequest $request, mixed $id): RedirectResponse
    {
        // Validate the name field
        $request->validated();
        $errMsg = (new ProdRepo())->updateProduct(
            $id,
            $request->safe()->only('id', 'description', 'name', 'price', 'image'),
            $request->file('image')
        );
        if ($errMsg) {
            Log::error($errMsg);
            return redirect()->route('admin.products')->withErrors('Failed to update product.');
        }
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    /**
     * @param array|bool|null|string $id
     * @return RedirectResponse
     */
    public function deleteProduct(mixed $id): RedirectResponse
    {
        if ((new ProdRepo())->deleteProduct($id)) {
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
        }
        return redirect()->route('admin.products')->withErrors('Failed to delete product');
    }

    /**
     * @return Factory|View|Application
     */
    public function addProductForm(): Factory|View|Application
    {
        return view('admin.add_product');
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function addProduct(ProductRequest $request): RedirectResponse
    {
        $valid = $request->validated();
        (new ProdRepo())->addProduct($valid, $request->file('image'));

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }
}
