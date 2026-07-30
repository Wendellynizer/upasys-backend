<?php

namespace App\Http\Controllers;

use App\Models\RentalUnit;
use App\Http\RentalUnit\Requests\StoreRentalUnitRequest;
use App\Http\RentalUnit\Requests\UpdateRentalUnitRequest;
use App\Http\Resources\RentalUnit\RentalUnitResource;

class RentalUnitController extends Controller
{
    
    public function index()
    {

        $rentalUnits = RentalUnit::all();

        return RentalUnitResource::collection($rentalUnits);
    }

    
    public function store(StoreRentalUnitRequest $request)
    {
        $newRentalUnit = $request->user()->rentalUnits()->create($request->validated());

        return response()->json([
            'data' => new RentalUnitResource($newRentalUnit),
            'message' => 'Created successfully'
        ], 201);
    }

    
    public function show(RentalUnit $rentalUnit)
    {
        return new RentalUnitResource($rentalUnit);
    }

    
    public function update(UpdateRentalUnitRequest $request, RentalUnit $rentalUnit)
    {
        
    }

    
    public function destroy(RentalUnit $rentalUnit)
    {
        
    }
}
