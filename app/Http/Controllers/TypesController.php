<?php

namespace App\Http\Controllers;

use App\Models\TypesModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as Log;
use Illuminate\Support\Facades\Validator;

class TypesController extends Controller
{
    public function index()
    {
        $dataTypes = TypesModel::all(); // Corrected variable name
        return view('layouts.pages.master-data.types.index', compact('dataTypes')); // Corrected parentheses and variable name
    }

    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|unique:types,name'
        ]);

        if ($validateData->fails()) {
            return redirect()->back()->withErrors($validateData)->withInput();
        }

        try {
            TypesModel::create([
                'name' => $request->name
            ]);

            return redirect()->route('indexTypes')->with('success', 'Types Add Succesfully');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Failed to update the data');
        }
    }

    public function update(Request $request, string $id)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|unique:types,name,' . $id,
        ]);

        try {
            // Find the record by ID and update it
            $typeData = TypesModel::findOrFail($id);
            $typeData->update([
                'name' => $request->name,
            ]);

            return redirect()->route('indexTypes')->with('success', 'Data updated successfully');
        } catch (\Throwable $e) {
            // Log the error message for debugging
            Log::error($e->getMessage());

            return redirect()->back()->with('error', 'Failed to update the data');
        }
    }





    public function destroy(string $id)
    {
        // Find the type by ID
        $typesData = TypesModel::find($id);

        // Check if the type exists
        if (!$typesData) {
            return redirect()->back()->with('error', 'An error occurred while deleting the type.');
        }

        // Delete the type
        $typesData->delete();

        // Redirect with a success message
        return redirect()->route('indexTypes')->with('success', 'Type deleted successfully.');
    }
}
