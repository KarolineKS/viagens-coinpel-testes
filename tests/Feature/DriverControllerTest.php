<?php

namespace Tests\Feature;

use App\Models\Driver;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DriverControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Testa se o método index retorna a view de motoristas.
     */
    public function test_index_retorna_view_de_motoristas(): void
    {
        $this->actingAsUser();
        Driver::factory()->count(3)->create();

        $response = $this->get(route('drivers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('drivers.index');
        $response->assertViewHas('drivers');
        $response->assertViewHas('autoOpen');
        $response->assertViewHas('editDriver');
    }

    /**
     * Testa método index com filtro de busca.
     */
    public function test_index_com_filtro_de_busca(): void
    {
        $this->actingAsUser();
        Driver::factory()->create(['name' => 'João Silva']);
        Driver::factory()->create(['email' => 'maria@example.com']);
        Driver::factory()->create(['registration_number' => 'REG123456']);

        // Search by name
        $response = $this->get(route('drivers.index', ['search' => 'João Silva']));
        $response->assertStatus(200);
        $drivers = $response->viewData('drivers');
        $this->assertCount(1, $drivers->items());

        // Search by email
        $response = $this->get(route('drivers.index', ['search' => 'maria@example.com']));
        $response->assertStatus(200);
        $drivers = $response->viewData('drivers');
        $this->assertCount(1, $drivers->items());

        // Search by registration number
        $response = $this->get(route('drivers.index', ['search' => 'REG123456']));
        $response->assertStatus(200);
        $drivers = $response->viewData('drivers');
        $this->assertCount(1, $drivers->items());
    }

    /**
     * Testa método index com parâmetro create.
     */
    public function test_index_com_parametro_create(): void
    {
        $this->actingAsUser();
        $response = $this->get(route('drivers.index', ['create' => true]));

        $response->assertStatus(200);
        $response->assertViewIs('drivers.index');
        $this->assertTrue($response->viewData('autoOpen'));
        $this->assertNull($response->viewData('editDriver'));
    }

    /**
     * Testa método index com parâmetro edit.
     */
    public function test_index_com_parametro_edit(): void
    {
        $this->actingAsUser();
        $driver = Driver::factory()->create();

        $response = $this->get(route('drivers.index', ['edit' => $driver->id]));

        $response->assertStatus(200);
        $response->assertViewIs('drivers.index');
        $this->assertTrue($response->viewData('autoOpen'));
        $this->assertEquals($driver->id, $response->viewData('editDriver')->id);
    }

    /**
     * Testa método create redireciona para index com parâmetro create.
     */
    public function test_create_redireciona_para_index_com_parametro_create(): void
    {
        $this->actingAsUser();
        $response = $this->get(route('drivers.create'));

        $response->assertRedirect(route('drivers.index', ['create' => true]));
    }

    /**
     * Testa método store cria motorista com sucesso.
     */
    public function test_store_cria_motorista_com_sucesso(): void
    {
        $this->actingAsUser();
        $driverData = [
            'name' => 'Carlos Silva',
            'birth_date' => '1985-05-15',
            'registration_number' => 'REG123456',
            'cpf' => '123.456.789-01',
            'rg' => '12.345.678-9',
            'zip_code' => '12345-678',
            'street' => 'Rua das Flores',
            'number' => '123',
            'city' => 'São Paulo',
            'state' => 'SP',
            'email' => 'carlos@example.com',
            'phone' => '(11) 98765-4321',
            'cnh_category' => 'D',
            'cnh_number' => '12345678901',
            'cnh_expiry_date' => '2025-12-31',
        ];

        $response = $this->post(route('drivers.store'), $driverData);

        $response->assertRedirect(route('drivers.index'));
        $response->assertSessionHas('success', 'Motorista cadastrado com sucesso!');

        $this->assertDatabaseHas('drivers', [
            'name' => 'Carlos Silva',
            'email' => 'carlos@example.com',
            'cpf' => '123.456.789-01',
        ]);
    }
}
