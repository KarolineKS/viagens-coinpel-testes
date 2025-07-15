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
use Illuminate\Http\UploadedFile;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index(Request $request)
    {
        // Usar apenas drivers ativos (não deletados)
        $query = Driver::active();

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


        $autoOpen = $request->has('create');
        $editDriver = null;

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

        // Upload da foto de perfil com compressão automática e validação
        if ($request->hasFile('profile_photo')) {
            $photoPath = $this->handlePhotoUpload($request->file('profile_photo'));

            if ($photoPath) {
                $data['profile_photo'] = $photoPath;
            } else {
                // If upload failed, return with error
                return Redirect::back()
                    ->withInput()
                    ->with('error', 'Erro ao fazer upload da foto. Verifique o tamanho e formato do arquivo.');
            }
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
        return redirect()->route('drivers.index', ['edit' => $driver->id]);
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
        $data = $request->except(['_token', '_method', 'profile_photo']);

        if ($request->hasFile('profile_photo')) {
            $newPhotoPath = $this->handlePhotoUpload($request->file('profile_photo'));

            if ($newPhotoPath) {

                $this->deleteOldPhoto($driver->profile_photo);
                $data['profile_photo'] = $newPhotoPath;
            } else {

                return Redirect::back()
                    ->withInput()
                    ->with('error', 'Erro ao fazer upload da foto. Verifique o tamanho e formato do arquivo.');
            }
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
        // Delete profile photo before deleting driver
        $this->deleteOldPhoto($driver->profile_photo);

        $driver->delete();

        return Redirect::route('drivers.index')
            ->with('success', 'Motorista deletado com sucesso!');
    }

    /**
     * Handle photo upload with optimization, compression and unique naming.
     */
    private function handlePhotoUpload(UploadedFile $file): ?string
    {
        try {
            // Validate file size (max 5MB)
            $maxSizeInBytes = 5 * 1024 * 1024; // 5MB
            if ($file->getSize() > $maxSizeInBytes) {
                Log::warning('Arquivo muito grande para upload: ' . $file->getSize() . ' bytes');
                return null;
            }

            // Validate file type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                Log::warning('Tipo de arquivo não permitido: ' . $file->getMimeType());
                return null;
            }

            // Generate unique filename
            $fileName = Str::uuid() . '.webp'; // Always save as WebP for better compression
            $directory = 'drivers/photos';
            $fullPath = $directory . '/' . $fileName;

            // Create directory if it doesn't exist
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Initialize Image Manager
            $manager = new ImageManager(new GdDriver());

            // Read and process the image
            $image = $manager->read($file->getPathname());

            // Resize image to maximum 800x800 while maintaining aspect ratio
            $image->scaleDown(800, 800);

            // Convert to WebP with 85% quality for optimal compression
            $processedImage = $image->toWebp(85);

            // Save the processed image
            Storage::disk('public')->put($fullPath, $processedImage);

            Log::info('Foto carregada com sucesso: ' . $fullPath);

            return $fullPath;
        } catch (\Exception $e) {
            Log::error('Erro no upload da foto: ' . $e->getMessage(), [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType()
            ]);

            return null;
        }
    }

    /**
     * Get optimized image dimensions while maintaining aspect ratio.
     */
    private function getOptimizedDimensions(int $originalWidth, int $originalHeight, int $maxWidth = 800, int $maxHeight = 800): array
    {
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);

        return [
            'width' => (int) ($originalWidth * $ratio),
            'height' => (int) ($originalHeight * $ratio)
        ];
    }

    /**
     * Delete old profile photo if exists.
     */
    private function deleteOldPhoto(?string $photoPath): void
    {
        if ($photoPath && Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
            Log::info('Foto antiga removida: ' . $photoPath);
        }
    }
}
