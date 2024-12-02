<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\order_header;
use App\Models\order_lines;
use App\Models\ProductInvertory;
use App\Models\ProductSize;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class POSController extends Controller
{
    public function index(Request $request){

        $category = $request->input('category', 'all');
        $inventoryItems = Inventory::where('category', 2)->get();

        if ($category === 'all') {
            // Fetch all products if category is 'all'
            $products = Product::where('product_status', '!=', 0)->get();
        } else {
            // Fetch products that match the selected category
            $products = Product::where('product_category', $category)
                                ->where('product_status', '!=', 0)
                                ->get();
        }

        return view('pages.POS.pos', compact('products', 'category', 'inventoryItems'));
    }

    public function getProductSizes(Request $request)
    {
        $productId = $request->input('product_id');

        // Fetch sizes associated with the given product_id
        $sizes = ProductSize::where('product_id', $productId)->get();

        return response()->json(['sizes' => $sizes]);
    }

    public function filterProducts(Request $request)
    {
        $category = $request->input('category');

        // Query to filter products based on the selected category
        if ($category == 'all') {
            $products = Product::where('product_status', '!=', 0)->get();
        } else {
            $products = Product::where('product_category', $category)
                                ->where('product_status', '!=', 0)
                                ->get();
        }

        return response()->json([
            'products' => $products
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = $request->input('cart');
        $totalAmount = 0;
        $productIds = [];
        $orderDetails = [];

        if (is_array($cart)) {
            foreach ($cart as $item) {
                if (is_array($item)) {
                    $totalAmount += $item['totalPrice'];
                    $productIds[] = $item['productId'];
                } else {
                    Log::error("Invalid item structure: ", [$item]);
                }
            }
        } else {
            Log::error("Invalid cart structure: ", [$cart]);
        }

        $productInventories = ProductInvertory::whereIn('product_id', $productIds)->get();

        foreach ($cart as $item) {
            $productInventoryItems = $productInventories->where('product_id', $item['productId']);

            foreach ($productInventoryItems as $productInventory) {
                $inventory = Inventory::find($productInventory->inventory_id);
                if ($inventory) {
                    $totalGramsNeeded = $item['quantity'] * $productInventory->grams;
                    $totalKgNeeded = $totalGramsNeeded / 1000; // Convert grams to kilograms

                    $inventory->stocks -= $totalKgNeeded;

                    $inventory->save();
                }
            }
        }

        // Save order header
        $order_header = new order_header();
        $order_header->user_id = Auth::id();
        $order_header->order_date = Carbon::now('Asia/Irkutsk');
        $order_header->total = $totalAmount;
        $order_header->save();

        // Save order lines
        foreach ($cart as $item) {
            $order_line = new order_lines();
            $order_line->order_header_id = $order_header->id;
            $order_line->product_id = $item['productId'];
            $order_line->quantity = $item['quantity'];
            $order_line->total = $item['totalPrice'];
            $order_line->inventory_ids = array_column($item['addOns'], 'id');
            $order_line->save();

            $orderDetails[] = [
                'productName' => $item['productName'],
                'quantity' => $item['quantity'],
                'total' => $item['totalPrice']
            ];
        }

        return response()->json([
            'message' => 'Checkout successful',
            'orderId' => $order_header->id,
            'orderDetails' => $orderDetails,
            'totalAmount' => $totalAmount,
            'date' => Carbon::now('Asia/Irkutsk')->toDateTimeString()
        ]);
    }

    public function showReceipt($orderId)
    {
        $order_header = order_header::with('orderLines.product')->findOrFail($orderId);

        $orderDetails = $order_header->orderLines->map(function ($orderLine) {
            $addOns = Inventory::whereIn('id', $orderLine->inventory_ids)->pluck('ingredients_name')->toArray();
            return [
                'productName' => $orderLine->product->product_name,
                'quantity' => $orderLine->quantity,
                'total' => $orderLine->total,
                'addOns' => $addOns // Fetch add-on names
            ];
        })->toArray();

        return view('receipt', [
            'date' => Carbon::parse($order_header->order_date)->toDateTimeString(),
            'totalAmount' => $order_header->total,
            'orderDetails' => $orderDetails
        ]);
    }









}
