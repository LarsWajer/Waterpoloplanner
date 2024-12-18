<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oefening;
use App\Models\Training;

class DataController extends Controller
{
    // Fetch requested Oefening
    public function index(Request $request)
    {
        $query = Oefening::query();

        // Select specific fields
        if ($request->has('field')) {
            $fields = explode(',', $request->get('field'));
            $query->select($fields);
        }

        // Apply conditions, including handling array values
        if ($request->has('conditions')) {
            foreach ($request->get('conditions') as $column => $value) {
                if ($column === 'id') {
                    // Handle IDs as an array
                    $query->whereIn('id', explode(',', $value));
                } else {
                    $query->where($column, $value);
                }
            }
        }

        return response()->json($query->get());
    }


    // Fetch a specific record
    public function show($id)
    {
        $Oefening = Oefening::findOrFail($id);
        return response()->json($Oefening);
    }

    // Create a new record
    public function store(Request $request)
    {
        $Oefening = Oefening::create($request->all());
        return response()->json($Oefening, 201);
    }

    // Update an existing record
    public function update(Request $request, $id)
    {
        $Oefening = Oefening::findOrFail($id);
        $Oefening->update($request->all());
        return response()->json($Oefening);
    }

    // Delete a record
    public function destroy($id)
    {
        $Oefening = Oefening::findOrFail($id);
        $Oefening->delete();
        return response()->json(['message' => 'Record deleted']);
    }

    public function store2(Request $request)
{
    dd('Controller is aangesproken');  // Dit zou je moeten helpen te zien of de controller wordt aangeroepen
}
}
