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

            return redirect()->route('indexTypes')->with('succes');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function update(Request $request, string $id)
    {
        // Validate the input
        $validateData = $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        try {
            // Find the record by ID
            $TypesData = TypesModel::findOrFail($id);


            $TypesData->update([
                'name' => $request->name,
            ]);


            return redirect()->route('indexTypes')->with('success', 'Data updated successfully');
        } catch (\Throwable $e) {

            Log::info($e->getMessage());

            return redirect()->back()->with('error', 'Failed to update the data');
        }
    }


    public function destroy(String $id) {
        $typesData = TypesModel::find($id);

        if (!$typesData) {
            return redirect()->back()->with('error', 'An error occurred while delete the Types');
        }
        $typesData->delete();
        return redirect()->route('typesData')->with('success');
    }
}
