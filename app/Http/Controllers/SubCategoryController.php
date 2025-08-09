<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Muestra una lista de subcategorías de una categoría específica.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function index(Category $category)
    {
        $subcategories = Subcategory::all();
        $categories = Category::all();

        return view('admin.subcategories.index', compact( 'subcategories', 'categories'));
    }

    /**
     * Muestra el formulario para crear una nueva subcategoría.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function create(Category $category)
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('category', 'categories'));
    }

    /**
     * Almacena una nueva subcategoría en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($request->all());

        return redirect()->route('subcategories.index')->with('success', 'Subcategoría creada exitosamente.');
    }

    /**
     * Muestra los detalles de una subcategoría específica.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\View\View
     */
    public function show(Category $category, Subcategory $subcategory)
    {
        $categories = Category::all();
        $products = Product::all();
        $product_subcategories = ProductSubcategory::where('subcategory_id', $subcategory->id)->get();
        $products = $products->whereIn('id', $product_subcategories->pluck('product_id')->toArray());
        return view('admin.subcategories.show', compact('categories', 'subcategory', 'products'));
    }

    /**
     * Muestra el formulario para editar una subcategoría.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\View\View
     */
    public function edit(Category $category, Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('categories', 'subcategory'));
    }

    /**
     * Actualiza una subcategoría en la base de datos y su estado asociado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update($request->all());
        
        // Lógica para actualizar el estado de los productos
        if ($request->input('status') == false) {
            $ProductSubcategory = ProductSubcategory::where('subcategory_id', $subcategory->id)->get();
            $Products = Product::whereIn('id', $ProductSubcategory->pluck('product_id')->toArray())->get();
            if ($Products->count() > 0) {
                $Products->each(function ($product) {
                    $product->status = false;
                    $product->save();
                });
            }
        }

        return redirect()->route('subcategories.index', $category)->with('success', 'Subcategoría actualizada exitosamente.');
    }

    /**
     * Elimina una subcategoría de la base de datos.
     *
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( Subcategory $subcategory)
    {
        $ProductSubcategory = ProductSubcategory::where('subcategory_id', $subcategory->id)->get();
        $Products = Product::whereIn('id', $ProductSubcategory->pluck('product_id')->toArray())->get();
        if ($Products->count() > 0) {
            $Products->each(function ($product) {
                $product->status = false;
                $product->save();
            });
        }
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('success', 'Subcategoría eliminada exitosamente.');
    }
}