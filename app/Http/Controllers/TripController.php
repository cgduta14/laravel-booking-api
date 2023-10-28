<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripRequest;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
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

        return response()->json($trips);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TripRequest $request): JsonResponse
    {
        Trip::create($request->all());

        return response()->json('Trip created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip): JsonResponse
    {
        return response()->json($trip);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TripRequest $request, Trip $trip): JsonResponse
    {
        $trip->update($request->all());

        return response()->json('Trip updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();

        return response(NULL,ResponseAlias::HTTP_NO_CONTENT);
    }

    public function getTripBySlug(string $slug): JsonResponse
    {
        return response()->json(Trip::where('slug', $slug)->firstOrFail());
    }
}
