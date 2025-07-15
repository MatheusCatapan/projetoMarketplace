<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
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
    public function show(Address $address)
    {
        $this->authorize('view', $address);
        return $address;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);
        $address->update($request->only(['street', 'city', 'state', 'zip']));
        return $address;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return response()->noContent();
    }
}
