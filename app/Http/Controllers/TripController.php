<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Http\Requests\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TripController extends Controller
{
    /**
     * Display a listing of the resource for the API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexApi()
    {
        $trips = Trip::select('id', 'name', 'status', 'departure_date')->get();
        return response()->json($trips);
    }

    /**
     * Display a listing of the trips.
     */
    public function index(Request $request): View
    {
        $query = Trip::with(['vehicle', 'driver']);


        if ($request->has('status') && $request->status !== '') {
            $query->byStatus($request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('origin', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhere('route', 'like', "%{$search}%")
                    ->orWhereHas('driver', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('model', 'like', "%{$search}%")
                            ->orWhere('license_plate', 'like', "%{$search}%");
                    });
            });
        }

        $trips = $query->orderBy('departure_date', 'desc')
            ->orderBy('departure_time', 'desc')
            ->paginate(10);

        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('trips.index', compact('trips', 'vehicles', 'drivers'));
    }

    /**
     * Show the form for creating a new trip.
     */
    public function create(): View
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('trips.create', compact('vehicles', 'drivers'));
    }

    /**
     * Store a newly created trip in storage.
     */
    public function store(TripRequest $request): RedirectResponse
    {
        Trip::create($request->validated());

        return redirect()->route('trips.index')
            ->with('success', 'Viagem criada com sucesso!');
    }

    /**
     * Display the specified trip.
     */
    public function show(Trip $trip): View
    {
        $trip->load(['vehicle', 'driver']);

        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified trip.
     */
    public function edit(Trip $trip): View
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('trips.edit', compact('trip', 'vehicles', 'drivers'));
    }

    /**
     * Update the specified trip in storage.
     */
    public function update(TripRequest $request, Trip $trip): RedirectResponse
    {
        $trip->update($request->validated());

        return redirect()->route('trips.index')
            ->with('success', 'Viagem atualizada com sucesso!');
    }

    /**
     * Remove the specified trip from storage.
     */
    public function destroy(Trip $trip): RedirectResponse
    {
        try {
            $trip->delete();
            return redirect()->route('trips.index')->with('success', 'Viagem excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('trips.index')->with('error', 'Erro ao excluir viagem. Tente novamente.');
        }
    }
}
