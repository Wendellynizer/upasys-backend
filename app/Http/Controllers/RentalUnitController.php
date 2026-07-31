<?php

namespace App\Http\Controllers;

use App\Models\RentalUnit;
use App\Http\Requests\RentalUnitRequests\StoreRentalUnitRequest;
use App\Http\Requests\RentalUnitRequests\UpdateRentalUnitRequest;
use App\Http\Resources\RentalUnit\RentalUnitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('update', $rentalUnit);

        $rentalUnit->update($request->validated());
        return response()->json([
            'data' => new RentalUnitResource($rentalUnit),
            'message' => 'Updated successfully'
        ]);
    }

     
    public function destroy(RentalUnit $rentalUnit)
    {
        Gate::authorize('delete', $rentalUnit);

        $rentalUnit->delete();

        return response()->noContent();
    }

    public function toggleAvailability(RentalUnit $rentalUnit) {

        Gate::authorize('update-rental-unit', $rentalUnit);

        $rentalUnit->is_available = !$rentalUnit->is_available;
        $rentalUnit->save();


        $message = "Unit has been " . ($rentalUnit->is_available ? 'enabled' : 'disabled');

        return response()->json([
            'message' => $message
        ]);
    }

    public function addTenant(Request $request, RentalUnit $rentalUnit) {
        
        Gate::authorize('addTenant', $rentalUnit);

        // create tenant

        // make unit unavailable

        // return response
    }
}
