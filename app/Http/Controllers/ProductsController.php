<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    public function index()
    {
        $dataProducts = ProductsModel::all(); // Corrected variable name
        return view('layouts.pages.master-data.products.index', compact('dataProducts')); // Corrected parentheses and variable name
    }




    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|unique:products,name',
            'images' => 'nullable|array',              // Images can be null or an array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:30720', // Validate each image
            'price' => 'required|numeric',
        ]);

        try {
            // Prepare data for the product
            $dataProduct = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
            ];

            // Check if images are uploaded
            if (isset($validatedData['images'])) {
                $imagePaths = [];

                // Loop through each image and upload it
                foreach ($validatedData['images'] as $image) {
                    if ($image->isValid()) { // Check if the image is valid
                        $path = $image->store('images', 'public');
                        $imagePaths[] = str_replace('/storage', 'storage', Storage::url($path));
                    }
                }

                // Store the image paths as JSON
                $dataProduct['images'] = json_encode($imagePaths);
                Log::info($dataProduct);
            }

            // Create the product
            ProductsModel::create($dataProduct);

            return redirect()->route('indexProduct')->with('success', 'Product created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to save product: ' . $th->getMessage())->withInput();
        }
    }



    public function stores(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|unique:products,name',
            'images' => 'nullable|array',              // Images can be null or an array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:30720', // Validate each image
            'price' => 'required|numeric',
        ]);

        try {
            // Prepare data for the product
            $dataProduct = [
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
            ];

            // Check if images are uploaded
            if (isset($validatedData['images'])) {
                $imagePaths = [];

                // Loop through each image and upload it
                foreach ($validatedData['images'] as $image) {
                    if ($image->isValid()) { // Check if the image is valid
                        $path = $image->store('images', 'public');
                        $imagePaths[] = str_replace('/storage', 'storage', Storage::url($path));
                    }
                }

                // Store the image paths as JSON
                $dataProduct['images'] = json_encode($imagePaths);
                Log::info($dataProduct);
            }

            // Create the product
            $product = ProductsModel::create($dataProduct);
            Log::info($product);

            // Return a JSON response
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'data' => $product,
            ], 201); // HTTP 201 Created

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save product: ' . $th->getMessage(),
            ], 500); // HTTP 500 Internal Server Error
        }
    }
}
