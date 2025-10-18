<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicles = Vehicle::all();
        $editVehicle = null;

        if ($request->has('edit')) {
            $editVehicle = Vehicle::find($request->get('edit'));
        }

        return view('vehicles.index', compact('vehicles', 'editVehicle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            $amenities = $data['amenities'] ?? [];
            unset($data['amenities']);

            foreach ($amenities as $amenity) {
                $data[$amenity] = true;
            }

            $vehicle = Vehicle::create($data);

            return redirect()->route('vehicles.index')
                ->with('success', 'Veículo "' . $vehicle->prefix . '" cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Erro ao cadastrar veículo. Tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        return redirect()->route('vehicles.index', ['edit' => $vehicle->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        try {
            $data = $request->validated();

            $vehicle->update([
                'has_internet' => false,
                'has_wc' => false,
                'has_power_outlet' => false,
                'has_ac' => false,
                'has_fridge' => false,
                'has_heating' => false,
                'has_video' => false,
            ]);

            $amenities = $data['amenities'] ?? [];
            unset($data['amenities']);

            foreach ($amenities as $amenity) {
                $data[$amenity] = true;
            }

            $vehicle->update($data);

            return redirect()->route('vehicles.index')
                ->with('success', 'Veículo "' . $vehicle->prefix . '" atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index', ['edit' => $vehicle->id])
                ->with('error', 'Erro ao atualizar veículo. Tente novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        try {
            $prefix = $vehicle->prefix;
            $vehicle->delete();

            return redirect()->route('vehicles.index')
                ->with('success', 'Veículo "' . $prefix . '" deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Erro ao deletar veículo. Tente novamente.');
        }
    }
}
