<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory;
use App\Models\ProductInvertory;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){
        return view('pages.product.product');
    }

    public function create(){

        $inventoryItems = Inventory::where('category', 1)->get();

        $inventoryItemsMaterials = Inventory::where('category', 3)->get();

        return view('pages.product.add', compact('inventoryItems', 'inventoryItemsMaterials'));
    }

    public function store(Request $request)
    {

        $filename = '';
        if ($request->hasFile('Attachment')) {
            $file = $request->file('Attachment');
            $filename = $file->getClientOriginalName();
            $file->move('uploads/', $filename);
        } else {
            Log::warning("No attachment found.");
        }

        $product = Product::create([
            'product_name' => $request->input('product-name'),
            'product_category' => $request->input('product-cat'),
            'product_status' => $request->input('status'),
            'image_name' => $filename,
        ]);

        // Reformat sizes for clarity
        $sizesFormatted = [];
        foreach ($request->input('sizes') as $index => $size) {
            $sizesFormatted["size_$index"] = $size;
        }
        // Ensure inventory items are unique
        $inventoryItems = array_unique($request->input('inventory_items'));

        // Initialize final inventory data array
        $inventoryData = [];

        // Process sizes and inventory items
        $sizes = $request->input('sizes');
        foreach ($sizes as $sizeIndex => $sizeData) {
            foreach ($inventoryItems as $inventoryId) {
                $quantityField = 'inventory_' . $inventoryId . '_quantity';
                $unitField = 'inventory_' . $inventoryId . '_unit';

                // Check if the fields exist in the current size data
                if (!array_key_exists($quantityField, $sizeData) || !array_key_exists($unitField, $sizeData)) {
                    continue; // Skip to the next inventory item
                }

                $quantity = $sizeData[$quantityField];
                $unit = $sizeData[$unitField];

                // Process the valid inventory data
                $inventoryData[] = [
                    'size_index' => $sizeIndex,
                    'inventory_id' => $inventoryId,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'category' => 1
                ];
            }
        }

        $inventoryItemsMaterials = array_unique($request->input('inventory_material_items'));

        $inventoryMaterialData = [];

        foreach ($sizes as $sizeIndex => $sizeData) {
            foreach ($inventoryItemsMaterials as $inventoryId) {
                $quantityField = 'inventory_' . $inventoryId . '_quantity';
                $unitField = 'inventory_' . $inventoryId . '_unit';

                // Check if the fields exist in the current size data
                if (!array_key_exists($quantityField, $sizeData) || !array_key_exists($unitField, $sizeData)) {
                    continue; // Skip to the next inventory item
                }

                $inventoryMaterialData[] = [
                    'size_index' => $sizeIndex,
                    'inventory_id' => $inventoryId,
                    'quantity' => 1,
                    'unit' => 'piece',
                    'category' => 3
                ];
            }
        }

        $product->inventory()->attach($inventoryData);
        $product->inventory()->attach($inventoryMaterialData);

        $sizes = $request->input('sizes');
        $prices = $request->input('prices');

        foreach ($sizes as $index => $size) {
            // Directly extract the price from the size object, assuming 'price' is a field within the size array
            $price = isset($size['price']) ? $size['price'] : null;  // Default to null if no price is found in the size

            // Only create if price exists
            if ($price !== null) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size['name'],  // Access the 'name' field from the size array
                    'price' => $price,
                    'size_index' => $index,  // Save the size_index for the product size
                ]);
            }
        }
        return redirect()->route('product')->with('success', 'Added Product Successfully!');
    }

    public function getData(Request $request){
        $searchTerm = $request->input('search');

        $query = Product::query();

        $query->with('sizes');

        if($searchTerm){
            $query->where(function ($innerQuery) use ($searchTerm) {
                $innerQuery->where('id', 'like', "%{$searchTerm}%")
                ->orWhere('product_name', 'like', "%{$searchTerm}%")
                ->orWhere('image_name', 'like', "%{$searchTerm}%");
            });
        }

        $product = $query->paginate(10);

        return response()->json($product);
    }

    public function edit(string $id){
        $findProduct = Product::find($id);

        Log::info("findProduct", [$findProduct->id]);

        $findProductInventoryIngredients = ProductInvertory::where('product_id', $findProduct->id)
                                                            ->where('category', 1)
                                                            ->get();

        Log::info("findProductInventoryIngredients", [$findProductInventoryIngredients]);

        $findProductInventoryMaterial = ProductInvertory::where('product_id', $id)
                                                        ->where('category', 3)
                                                        ->get();

        Log::info("findProductInventoryIngredientsMaterial", [$findProductInventoryMaterial]);

        $inventoryItems = Inventory::where('category', 1)->get();

        $inventoryItemsMaterials = Inventory::where('category', 3)->get();

        $findProductSize = ProductSize::where('product_id', $id)->get();

        Log::info("findProductSize", [$findProductSize]);

        if (!$findProduct && $findProductInventoryIngredients) {
            return view('errors.404');
        }

        $groupedData = $findProductSize->map(function ($size) use ($findProductInventoryIngredients) {
            return [
                'size' => $size,
                'ingredients' => $findProductInventoryIngredients->where('size_index', $size->size_index),
            ];
        });

        Log::info("groupedData", [$groupedData]);

        return view('pages.product.edit', compact('findProduct', 'findProductSize', 'findProductInventoryIngredients', 'findProductInventoryMaterial', 'inventoryItems', 'inventoryItemsMaterials', 'groupedData'));
    }

    public function update($id, Request $request) {
        // Validate the incoming request data
        $request->validate([
            'product-name' => 'required',
            'product-cat' => 'required',
            'status' => 'required',
            'inventory_items' => 'required|array',
            'sizes' => 'required|array',      // Validate sizes as an array
            'sizes.*' => 'required|string',   // Each size should be a string
            'prices' => 'required|array',     // Validate prices as an array
            'prices.*' => 'required|numeric|min:0', // Each price should be a number
        ]);

        try {
            // Find the product by id, or throw an exception if not found
            $getProd = Product::findOrFail($id);

            Log::info("getProd", [$getProd]);

            // Prepare the data for updating
            $updateData = [
                'product_name' => $request->input('product-name'),
                'product_category' => $request->input('product-cat'),
                'product_status' => $request->input('status'),
            ];

            // Handle image upload if provided
            if ($request->hasFile('Attachment')) {
                $file = $request->file('Attachment');
                $filename = $file->getClientOriginalName();
                $file->move('uploads/', $filename);
                $updateData['image_name'] = $filename;
            }

            $updateResult = $getProd->update($updateData);

            $inventoryData = [];

            Log::info("Inventory Ingredients", [$request->input('inventory_items')]);
            foreach ($request->input('inventory_items') as $inventoryId) {
                $quantityInputName = 'inventory_' . $inventoryId . '_quantity';
                $quantity = $request->input($quantityInputName);

                $unitInputName = 'inventory_' . $inventoryId . '_unit';
                $unit = $request->input($unitInputName);

                if ($quantity === null || $unit === null) {
                    Log::error("Missing quantity or unit for inventory item:", [
                        'inventoryId' => $inventoryId,
                        'quantity' => $quantity,
                        'unit' => $unit
                    ]);
                    return redirect()->back()->withErrors(['msg' => 'Please fill in all quantity and unit fields.']);
                }

                // Instead of overwriting, allow multiple entries for the same inventoryId
                $inventoryData[] = [
                    'inventory_id' => $inventoryId,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'category' => 1,
                ];
            }

            $inventoryMaterialItems = $request->input('inventory_material_items', []);
            foreach ($inventoryMaterialItems as $inventoryMaterialsId) {
                $inventoryData[] = [
                    'inventory_id' => $inventoryMaterialsId,
                    'quantity' => 1,
                    'unit' => "piece",
                    'category' => 3,
                ];
            }

            $getProd->inventory()->sync($inventoryData);

            // Update sizes and prices for the product
            $sizes = $request->input('sizes');
            $prices = $request->input('prices');

            // Delete existing sizes before adding new ones (optional, if you want to replace them)
            $getProd->sizes()->delete();

            foreach ($sizes as $index => $size) {
                // Create a new ProductSize entry for each size and price
                ProductSize::create([
                    'product_id' => $getProd->id,  // Link the size to the product
                    'size' => $size,
                    'price' => $prices[$index],    // Use the corresponding price for this size
                ]);
            }

            if ($updateResult) {
                return redirect()->route('product')->with('success', 'The product has been updated successfully');
            } else {
                Log::error('Failed to update product for id: ' . $id);
                return redirect()->route('product')->with('error', 'Failed to update product. Please try again.');
            }
        } catch (ModelNotFoundException $e) {
            Log::error('Product not found for id: ' . $id);
            return redirect()->route('product')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            Log::error('Error updating product for id: ' . $id, ['error' => $e->getMessage()]);
            return redirect()->route('product')->with('error', 'An error occurred. Please try again.');
        }
    }


    public function delete(Request $request) {
        try {
            $productID = $request->input('prod_id');

            // Find the product by ID, or throw an exception if not found
            $prod = Product::findOrFail($productID);

            // Check if the product has an associated image
            if ($prod->image_name) {
                $imagePath = public_path('uploads/' . $prod->image_name);

                // Check if the file exists before attempting to delete
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image from the server
                }
            }

            // Delete the product from the database
            $prod->delete();

            return response()->json([
                'message' => 'The product has been deleted successfully',
                'icon' => 'success',
                'title' => 'Success'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to delete product for id: ' . $request->input('prod_id'), ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to delete product'], 500);
        }
    }




}
