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
     * Retrieves a paginated list of drivers with optional search filtering and modal state.
     *
     * Applies search filters on name, email, registration number, or CNH number if provided in the request. Determines whether to auto-open create or edit modals based on request parameters and passes the relevant driver to edit if applicable.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // SoftDeletes trait automaticamente exclui drivers deletados
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


        $autoOpen = $request->has('create');
        $editDriver = null;

        if ($request->has('edit')) {
            $editDriver = Driver::findOrFail($request->edit);
            $autoOpen = true;
        }

        return view('drivers.index', compact('drivers', 'autoOpen', 'editDriver'));
    }

    /**
     * Redirects to the drivers index route with a parameter to open the create modal.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('drivers.index', ['create' => true]);
    }

    /**
     * Creates a new driver record with validated data and optional profile photo upload.
     *
     * If a profile photo is provided, it is validated, processed, and stored. On upload failure, redirects back with an error message. On success, redirects to the driver index with a success message.
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Redirects to the driver index route with a parameter to open the edit modal for the specified driver.
     *
     * @param Driver $driver The driver to edit.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Driver $driver)
    {
        return redirect()->route('drivers.index', ['edit' => $driver->id]);
    }

    /**
     * Updates the specified driver with validated data and handles profile photo replacement if a new photo is uploaded.
     *
     * If a new profile photo is provided, processes and stores the image, deletes the old photo, and updates the driver's photo path. Redirects back with an error message if the upload fails. On success, redirects to the drivers index with a success message.
     *
     * @param DriverRequest $request The validated request containing driver data and optional profile photo.
     * @param Driver $driver The driver instance to update.
     * @return \Illuminate\Http\RedirectResponse
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
     * Deletes the specified driver and removes their profile photo from storage if it exists.
     *
     * @param Driver $driver The driver to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the drivers index with a success message.
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
     * Processes and uploads a driver profile photo with validation, resizing, and WebP conversion.
     *
     * Validates the uploaded file's size and MIME type, resizes the image to a maximum of 800x800 pixels while maintaining aspect ratio, converts it to WebP format with 85% quality, and stores it with a unique filename in the public storage. Returns the storage path on success or null if validation fails or an error occurs.
     *
     * @param UploadedFile $file The uploaded image file to process.
     * @return string|null The storage path of the processed image, or null on failure.
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
     * Deletes the specified old profile photo from public storage if it exists.
     *
     * Does nothing if the photo path is null or the file does not exist.
     */
    private function deleteOldPhoto(?string $photoPath): void
    {
        if ($photoPath && Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
            Log::info('Foto antiga removida: ' . $photoPath);
        }
    }
}
