<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Error;
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


    public function addIndex()
    {
        return view('layouts.pages.master-data.products.add');
    }

    public function editIndex(string $id)
    {
        $editProducts = ProductsModel::findOrFail($id); // Use $id directly here
        Log::info($editProducts);
        return view('layouts.pages.master-data.products.edit', compact('editProducts'));
    }

    public function update(Request $request, string $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $id,
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:30720',
            'price' => 'required|numeric',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Find the existing product by ID
            $product = ProductsModel::findOrFail($id);

            // Prepare data for the product
            $dataProduct = [
                'name' => $request->input('name'),  // Use input from the request
                'price' => $request->input('price'), // Use input from the request
            ];

            // Check if images are uploaded
            if ($request->has('images')) {
                $imagePaths = [];

                // Loop through each image and upload it
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) { // Check if the image is valid
                        $path = $image->store('images', 'public');
                        $imagePaths[] = str_replace('/storage', 'storage', Storage::url($path));
                    }
                }

                // Store the image paths as JSON
                $dataProduct['images'] = json_encode($imagePaths);
            }

            // Update the product
            $product->update($dataProduct);

            return redirect()->route('indexProduct')->with('success', 'Product updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update product: ' . $th->getMessage())->withInput();
        }
    }






    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:30720',
            'price' => 'required|numeric',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Prepare data for the product
            $dataProduct = [
                'name' => $request->input('name'),  // Use input from the request
                'price' => $request->input('price'), // Use input from the request
            ];

            // Check if images are uploaded
            if ($request->has('images')) {
                $imagePaths = [];

                // Loop through each image and upload it
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) { // Check if the image is valid
                        $path = $image->store('images', 'public');
                        $imagePaths[] = str_replace('/storage', 'storage', Storage::url($path));
                    }
                }

                // Store the image paths as JSON
                $dataProduct['images'] = json_encode($imagePaths);
            }

            // Create the product
            ProductsModel::create($dataProduct);
            return redirect()->route('indexProduct')->with('success', 'Product Add Succesfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to save product: ' . $th->getMessage())->withInput();
        }
    }




    // public function stores(Request $request)
    // {
    //     // Define validation rules
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:products,name',
    //         'images' => 'nullable|array',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:30720',
    //         'price' => 'required|numeric',
    //     ]);

    //     // Handle validation errors
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     try {
    //         // Collect validated data
    //         $validatedData = $validator->validated();
    //         $dataProduct = [
    //             'name' => $validatedData['name'],
    //             'price' => $validatedData['price'],
    //         ];

    //         // Handle image uploads if any
    //         if (isset($validatedData['images'])) {
    //             $imagePaths = [];
    //             foreach ($validatedData['images'] as $image) {
    //                 if ($image->isValid()) {
    //                     $path = $image->store('images', 'public');
    //                     $imagePaths[] = Storage::url($path);
    //                 }
    //             }
    //             $dataProduct['images'] = json_encode($imagePaths);
    //         }

    //         // Save product to the database
    //         $product = ProductsModel::create($dataProduct);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Product created successfully!',
    //             'data' => $product,
    //         ], 201);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to save product: ' . $th->getMessage(),
    //         ], 500);
    //     }
    // }
}
