<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $subcategories = Subcategory::all();
        $product_subcategories = ProductSubcategory::all();
        // $subcategoryIds = ProductSubcategory::pluck('subcategory_id')->toArray();
        // $subcategories = Subcategory::whereIn('id', $subcategoryIds)->get();
        // Recorrer array de subcategories y agregarlos a la vista
        // foreach($subcategories as $subcategory) {
        //     $arrSubcategories[] = $subcategory->name;
        // }
        // if (isset($arrSubcategories)) {
        //     $arrSubcategories = implode(', ', $arrSubcategories);
        //     return view('admin.products.index', compact('products', 'arrSubcategories'));
        // }
        return view('admin.products.index', compact('products', 'subcategories', 'product_subcategories'));
    }

    public function create()
    {
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_ids' => 'required|string', // Validar la cadena de IDs
            'status' => 'boolean',
        ]);
        if ($request->input('subcategory_ids') === null) {
            return redirect()->back()->with('subcategory_ids', 'Debe seleccionar al menos una subcategoría.')->withInput();
        }
        // Obtener los IDs de las subcategorías del input oculto
        $subcategoryIds = explode(',', $request->input('subcategory_ids'));

        // Crear el producto primero
        $product = Product::create([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        // Guardar las relaciones de muchos a muchos en la tabla product_subcategory
        foreach ($subcategoryIds as $subcategoryId) {
            ProductSubcategory::create([
                'product_id' => $product->id,
                'subcategory_id' => $subcategoryId,
            ]);
        }
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        // Obtiene todas las subcategorías disponibles para el menú desplegable
        $allSubcategories = Subcategory::all();

        // Obtiene los IDs de las subcategorías asociadas al producto actual
        // La relación `subcategories()` ya sabe cómo usar la tabla pivote
        $selectedSubcategoryIds = $product->subcategories()->pluck('id')->toArray();

        // Pasa el producto, todas las subcategorías y los IDs de las seleccionadas a la vista
        return view('admin.products.edit', compact('product', 'allSubcategories', 'selectedSubcategoryIds'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_ids' => 'nullable|string', // Validar la cadena de IDs
            'status' => 'boolean',
        ]);

        $product->update([
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        // Obtener los IDs del input oculto. Si es null, usar un array vacío.
        $subcategoryIds = $request->input('subcategory_ids') ? explode(',', $request->input('subcategory_ids')) : [];

        // Usar el método sync() para sincronizar las relaciones.
        // Esto eliminará las subcategorías que no estén en $subcategoryIds y agregará las nuevas.
        $product->subcategories()->sync($subcategoryIds);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        // Eliminar las relaciones antiguas
        ProductSubcategory::where('product_id', $product->id)->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
