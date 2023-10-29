<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Trip;

class ReservationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function book(StoreReservationRequest $request, Trip $trip)
    {
        $validated = $request->validated();
        $reservation = Reservation::create(
            [
                'user_id' => $request->user()->id,
                'trip_id' => $trip->id,
                'special_requests' => $validated['special_requests'] ?? null
            ]
        );

        return new ReservationResource($reservation);
    }
}
