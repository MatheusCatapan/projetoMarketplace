<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return $request->user()->addresses;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ]);
        $address = $request->user()->addresses()->create($data);
        return $address;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view', $address);
        return $address;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $address);
        $address->update($request->only(['strees', 'city', 'state', 'zip']));
        return $address;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', $address);
        $address->delete;
        return response()->noContent();
    }
}
