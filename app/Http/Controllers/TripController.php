<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
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
            try {
                $trips = $trips->orderByCol($request->query('orderBy'), $request->query('orderDir') ?? 'ASC');
            } catch (\Exception $e){
                var_dump($e->getMessage());
            }
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
