<?php

namespace App\Http\Controllers;

use App\Models\RentalUnit;
use App\Http\Requests\RentalUnitRequests\StoreRentalUnitRequest;
use App\Http\Requests\RentalUnitRequests\UpdateRentalUnitRequest;
use App\Http\Requests\TenantRequest\StoreTenantFormRequest;
use App\Http\Resources\RentalUnit\RentalUnitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RentalUnitController extends Controller
{

    public function index(Request $request)
    {

        $rentalUnits = RentalUnit::where('unit_owner_id', $request->user()->id)
            ->with(['tenant'])
            ->get();

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
        return RentalUnitResource::make(
            $rentalUnit->load([
                'tenant',
                'rental_payments'
            ])
        );
    }


    public function update(UpdateRentalUnitRequest $request, RentalUnit $rentalUnit)
    {
        Gate::authorize('update', $rentalUnit);

        $rentalUnit->update($request->validated());
        return response()->json([
            'data' => RentalUnitResource::make($rentalUnit),
            'message' => 'Updated successfully'
        ], 200);
    }


    public function destroy(RentalUnit $rentalUnit)
    {
        Gate::authorize('delete', $rentalUnit);

        $rentalUnit->delete();

        return response()->noContent();
    }

    public function toggleAvailability(RentalUnit $rentalUnit)
    {

        Gate::authorize('update-rental-unit', $rentalUnit);

        $rentalUnit->update([
            'is_available' => !$rentalUnit->is_available
        ]);

        // $rentalUnit->is_available = !$rentalUnit->is_available;
        // $rentalUnit->save();


        $message = "Unit has been " . ($rentalUnit->is_available ? 'enabled' : 'disabled');

        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * rental-units.create-tenant
     */
    public function addTenant(StoreTenantFormRequest $request, RentalUnit $rentalUnit)
    {

        Gate::authorize('addTenant', $rentalUnit);

        abort_if($rentalUnit->tenant()->exists(), 400, $message = 'There is already a tenant.');

        try {

            $tenantDetails = DB::transaction(function () use ($request, $rentalUnit) {

                $validatedData = $request->validated();

                // $tenantData = array_diff_key($validatedData, array_flip([
                //     'has_downpayment',
                //     'payment_amount',
                //     'date_paid',
                // ]));

                $tenantData = Arr::except(
                    $validatedData,
                    [
                        'has_downpayment',
                        'payment_amount',
                        'date_paid',
                    ]
                );

                $newTenant = $rentalUnit->tenant()->create($tenantData);

                // make unit unavailable
                $rentalUnit->update(['is_available' => false]);

                // add downpayment if available
                if ($request->boolean('has_downpayment')) {

                    $rentalUnit->rentalPayments()->create([
                        'payment_amount' => $validatedData['payment_amount'],
                        'date_paid' => $validatedData['date_paid'] ?? now(),
                        'tenant_id' => $newTenant->id,
                    ]);
                }

                return $newTenant;
            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }


        // return response
        return response()->json([
            'message' => 'Added tenant to unit successfully',
            'data' => $tenantDetails
        ], 201);
    }
}
