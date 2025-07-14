<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\View\View;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index(Request $request)
    {
        $query = Driver::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('cnh_number', 'like', "%{$search}%");
            });
        }

        $drivers = $query->latest()->paginate(10);

        // Auto-abertura do offcanvas
        $autoOpen = $request->has('create');
        $editDriver = null;

        // Edição de motorista
        if ($request->has('edit')) {
            $editDriver = Driver::find($request->edit);
            $autoOpen = true;
        }

        return view('drivers.index', compact('drivers', 'autoOpen', 'editDriver'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('drivers.index', ['create' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverRequest $request)
    {
        $data = [
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'registration_number' => $request->registration_number,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'zip_code' => $request->zip_code,
            'street' => $request->street,
            'number' => $request->number,
            'city' => $request->city,
            'state' => $request->state,
            'email' => $request->email,
            'phone' => $request->phone,
            'cnh_category' => $request->cnh_category,
            'cnh_number' => $request->cnh_number,
            'cnh_expiry_date' => $request->cnh_expiry_date,
        ];

        // Upload da foto de perfil com nome único e otimização
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $this->handlePhotoUpload($request->file('profile_photo'));
        }

        Driver::create($data);

        return Redirect::route('drivers.index')
            ->with('success', 'Motorista cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        return response()->json($driver);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        return redirect()->route('drivers.index', ['edit' => $driver->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        $data = [
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'registration_number' => $request->registration_number,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'zip_code' => $request->zip_code,
            'street' => $request->street,
            'number' => $request->number,
            'city' => $request->city,
            'state' => $request->state,
            'email' => $request->email,
            'phone' => $request->phone,
            'cnh_category' => $request->cnh_category,
            'cnh_number' => $request->cnh_number,
            'cnh_expiry_date' => $request->cnh_expiry_date,
        ];


        if ($request->hasFile('profile_photo')) {

            if ($driver->profile_photo) {
                Storage::disk('public')->delete($driver->profile_photo);
            }
            $data['profile_photo'] = $this->handlePhotoUpload($request->file('profile_photo'));
        }

        $driver->update($data);

        return Redirect::route('drivers.index')
            ->with('success', 'Motorista atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        if ($driver->profile_photo) {
            Storage::disk('public')->delete($driver->profile_photo);
        }

        $driver->delete();

        return Redirect::route('drivers.index')
            ->with('success', 'Motorista deletado com sucesso!');
    }

    /**
     * Handle photo upload with optimization and unique naming.
     */
    private function handlePhotoUpload($file)
    {
        try {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = 'drivers/photos/' . $fileName;


            Storage::disk('public')->makeDirectory('drivers/photos');


            $fullPath = Storage::disk('public')->putFileAs('drivers/photos', $file, $fileName);

            // Otimiza a imagem (redimensiona para 400x400 mantendo proporção)
            $imagePath = storage_path('app/public/' . $fullPath);

            $manager = new ImageManager(new GdDriver());
            $image = $manager->read($imagePath);
            $image->cover(400, 400);
            $image->save($imagePath, 85); // 85% de qualidade

            return $fullPath;
        } catch (\Exception $e) {
            Log::error('Erro no upload da foto: ' . $e->getMessage());

            return null;
        }
    }
}
