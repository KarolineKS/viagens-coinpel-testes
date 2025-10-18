<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa método index retorna view de veículos.
     */
    public function test_index_retorna_view_de_veiculos(): void
    {
        $this->actingAsUser();
        Vehicle::factory()->count(3)->create();

        $response = $this->get(route('vehicles.index'));

        $response->assertStatus(200);
        $response->assertViewIs('vehicles.index');
        $response->assertViewHas('vehicles');
    }

    /**
     * Testa método index com parâmetro edit.
     */
    public function test_index_com_parametro_edit(): void
    {
        $this->actingAsUser();
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.index', ['edit' => $vehicle->id]));

        $response->assertStatus(200);
        $response->assertViewIs('vehicles.index');
        $response->assertViewHas('vehicles');
    }

    /**
     * Testa método store cria veículo com sucesso.
     */
    public function test_store_cria_veiculo_com_sucesso(): void
    {
        $this->actingAsUser();

        $vehicleData = [
            'identification_name' => 'Ônibus Teste',
            'prefix' => 'TEST',
            'license_plate' => 'ABC1234',
            'model' => 'Mercedes-Benz',
            'chassis' => '123456789',
            'vehicle_type' => 'Ônibus',
            'capacity' => 40,
            'year' => 2020,
            'seating_layout' => 'Convencional',
            'has_internet' => true,
            'has_wc' => true,
            'has_power_outlet' => true,
            'has_ac' => true,
            'has_fridge' => false,
            'has_heating' => false,
            'has_video' => false,
        ];

        $response = $this->post(route('vehicles.store'), $vehicleData);

        $response->assertRedirect(route('vehicles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('vehicles', [
            'identification_name' => 'Ônibus Teste',
            'prefix' => 'TEST',
            'capacity' => 40,
        ]);
    }

    /**
     * Testa método show retorna JSON do veículo.
     */
    public function test_show_retorna_json_do_veiculo(): void
    {
        $this->actingAsUser();
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.show', $vehicle));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $vehicle->id,
            'identification_name' => $vehicle->identification_name,
            'prefix' => $vehicle->prefix,
        ]);
    }

    /**
     * Testa método edit redireciona para index com parâmetro edit.
     */
    public function test_edit_redireciona_para_index_com_parametro_edit(): void
    {
        $this->actingAsUser();
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.edit', $vehicle));

        $response->assertRedirect(route('vehicles.index', ['edit' => $vehicle->id]));
    }

    /**
     * Testa método update atualiza veículo com sucesso.
     */
    public function test_update_atualiza_veiculo_com_sucesso(): void
    {
        $this->actingAsUser();
        $vehicle = Vehicle::factory()->create([
            'identification_name' => 'Ônibus Antigo',
            'capacity' => 30,
        ]);

        $updateData = [
            'identification_name' => 'Ônibus Atualizado',
            'prefix' => $vehicle->prefix,
            'license_plate' => $vehicle->license_plate,
            'model' => $vehicle->model,
            'chassis' => $vehicle->chassis,
            'vehicle_type' => $vehicle->vehicle_type,
            'capacity' => 50,
            'year' => $vehicle->year,
            'seating_layout' => $vehicle->seating_layout,
            'has_internet' => $vehicle->has_internet,
            'has_wc' => $vehicle->has_wc,
            'has_power_outlet' => $vehicle->has_power_outlet,
            'has_ac' => $vehicle->has_ac,
            'has_fridge' => $vehicle->has_fridge,
            'has_heating' => $vehicle->has_heating,
            'has_video' => $vehicle->has_video,
        ];

        $response = $this->put(route('vehicles.update', $vehicle), $updateData);

        $response->assertRedirect(route('vehicles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
            'identification_name' => 'Ônibus Atualizado',
            'capacity' => 50,
        ]);
    }

    /**
     * Testa método destroy deleta veículo com sucesso.
     */
    public function test_destroy_deleta_veiculo_com_sucesso(): void
    {
        $this->actingAsUser();
        $vehicle = Vehicle::factory()->create();

        $response = $this->delete(route('vehicles.destroy', $vehicle));

        $response->assertRedirect(route('vehicles.index'));
        $response->assertSessionHas('success');

        // Verifica se o veículo foi deletado (pode ser soft delete ou hard delete)
        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
            'deleted_at' => null,
        ]);
    }
}
