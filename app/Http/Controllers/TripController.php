<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripRequest;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Trip::all());
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
}
