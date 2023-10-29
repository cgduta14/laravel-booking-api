<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $trips = Trip::query();
        if ($request->query('orderBy')) {
            $orderBy = $request->query('orderBy');
            if (!in_array($orderBy, ['id', 'start_date', 'end_date', 'price'])) {
                return response()->json('Column not allowed for orderBy', 500);
            }

            $orderDir = $request->query('orderDir') ?? 'ASC';
            if (!in_array(strtoupper($orderDir), ['ASC', 'DESC'])) {
                return response()->json('Term not allowed for orderDir. Use only ASC/DESC', 500);
            }

            $trips = $trips->orderByCol($orderBy, $orderDir);
        }
        if ($request->query('search')) {
            $trips = $trips->searchBy($request->query('search'));
        }
        if ($request->query('priceFrom')) {
            $trips = $trips->priceFrom($request->query('priceFrom'));
        }
        if ($request->query('priceTo')) {
            $trips = $trips->priceTo($request->query('priceTo'));
        }
        $trips = $trips->get();

        return new TripCollection($trips);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTripRequest $request)
    {
        $validated = $request->validated();
        $trip = Trip::create($validated);

        return new TripResource($trip);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        return new TripResource($trip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $validated = $request->validated();
        $trip->update($validated);

        return new TripResource($trip);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response(NULL,ResponseAlias::HTTP_NO_CONTENT);
    }

    public function getTripBySlug(string $slug)
    {
        $trip = Trip::where('slug', $slug)->firstOrFail();

        return new TripResource($trip);
    }
}
