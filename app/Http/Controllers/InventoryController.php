<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        return view('pages.inventory.inventory');
    }

    public function indexAddOns()
    {
        return view('pages.inventory.addOns');
    }

    public function indexMaterials()
    {
        return view('pages.inventory.materials');
    }

    public function store(Request $request, $category = 1)
    {
        $request->validate([
            'ingredients-name' => 'required|string',
            'stock' => 'required|integer',
            'unit' => 'required|string',
        ]);

        return $this->saveInventory($request, $category);
    }

    public function storeAddOns(Request $request)
    {
        return $this->store($request, 2);
    }

    public function storeMaterials(Request $request)
    {
        $request->validate([
            'ingredients-name' => 'required|string',
            'stock' => 'required|integer',
        ]);

        return $this->saveInventory($request, 3);
    }

    private function saveInventory($request, $category)
    {
        try {
            $inventory = new Inventory();
            $inventory->ingredients_name = $request->input('ingredients-name');
            $inventory->stocks = $request->input('stock');
            $inventory->category = $category;
            $inventory->unit = $request->input('unit');
            $inventory->save();

            $message = $category === 1 ? 'Ingredients' : ($category === 2 ? 'Add Ons' : 'Materials');
            return response()->json(['message' => "The $message has been added successfully."], 200);

        } catch (\Exception $e) {
            Log::error("Error occurred while saving item: " . $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving item'], 500);
        }
    }

    public function checkInventory(Request $request)
    {
        $inventory = Inventory::where('ingredients_name', $request->input('ingredientsName'))
                              ->where('id', '!=', $request->input('id'))
                              ->first();

        return response()->json(['exists' => (bool)$inventory]);
    }

    public function getData(Request $request, $category = 1)
    {
        $searchTerm = $request->input('search');
        $inventory = Inventory::where('category', $category)
                              ->when($searchTerm, function ($query) use ($searchTerm) {
                                  $query->where('id', 'like', "%{$searchTerm}%")
                                        ->orWhere('ingredients_name', 'like', "%{$searchTerm}%")
                                        ->orWhere('stocks', 'like', "%{$searchTerm}%");
                              })
                              ->paginate(10);

        return response()->json($inventory);
    }

    public function getDataAddOns(Request $request)
    {
        return $this->getData($request, 2);
    }

    public function getDataMeterials(Request $request)
    {
        return $this->getData($request, 3);
    }

    public function edit(Request $request)
    {
        try {

            $inventory = Inventory::findOrFail($request->input('inv_id'));
            $inventory->ingredients_name = $request->input('ingredientsName');
            $inventory->stocks = $request->input('stock');

            if($request->input('unit')){
                $inventory->unit = $request->input('unit');
            }
            $inventory->save();

            return response()->json(['message' => 'The inventory has been updated successfully.'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("Validation error: " . $e->getMessage());
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info("Else");
            Log::error("Error updating inventory: " . $e->getMessage());
            return response()->json(['message' => 'Failed to update inventory'], 500);
        }
    }



    public function delete(Request $request)
    {
        try {
            $inventory = Inventory::findOrFail($request->input('inv_id'));
            $inventory->delete();

            return response()->json(['message' => 'The inventory has been deleted successfully.', 'icon' => 'success', 'title' => 'Success'], 200);
        } catch (\Exception $e) {
            Log::error("Failed to delete inventory: " . $e->getMessage());
            return response()->json(['error' => 'Failed to delete inventory'], 500);
        }
    }
}
