<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use App\Models\Trip;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Testes unitários para o modelo Vehicle
 * 
 * @group unit
 * @group models
 * @group vehicle
 */
class VehicleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa criação de veículo com dados válidos.
     */
    public function test_pode_criar_veiculo_com_dados_validos(): void
    {
        $vehicleData = [
            'identification_name' => 'AQ 942',
            'prefix' => 'AQ',
            'license_plate' => 'ABC1234',
            'model' => 'Volvo B290R',
            'chassis' => 'UT56520747',
            'vehicle_type' => 'Micro-ônibus',
            'capacity' => 30,
            'year' => 2022,
            'seating_layout' => 'Leito',
            'has_internet' => true,
            'has_wc' => true,
            'has_power_outlet' => true,
            'has_ac' => true,
            'has_fridge' => true,
            'has_heating' => true,
            'has_video' => false,
        ];

        $vehicle = Vehicle::create($vehicleData);

        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals('AQ 942', $vehicle->identification_name);
        $this->assertEquals('AQ', $vehicle->prefix);
        $this->assertEquals('ABC1234', $vehicle->license_plate);
        $this->assertEquals('Volvo B290R', $vehicle->model);
        $this->assertEquals(30, $vehicle->capacity);
        $this->assertTrue($vehicle->has_internet);
        $this->assertFalse($vehicle->has_video);

        $this->assertDatabaseHas('vehicles', [
            'identification_name' => 'AQ 942',
            'prefix' => 'AQ',
            'license_plate' => 'ABC1234',
        ]);
    }

    /**
     * Testa atributos fillable do veículo.
     */
    public function test_veiculo_tem_atributos_fillable_corretos(): void
    {
        $vehicle = new Vehicle();
        $expectedFillable = [
            'identification_name',
            'prefix',
            'license_plate',
            'model',
            'chassis',
            'vehicle_type',
            'capacity',
            'year',
            'seating_layout',
            'has_internet',
            'has_wc',
            'has_power_outlet',
            'has_ac',
            'has_fridge',
            'has_heating',
            'has_video',
        ];

        $this->assertEquals($expectedFillable, $vehicle->getFillable());
    }

    /**
     * Testa relacionamento veículo tem muitas viagens.
     */
    public function test_veiculo_tem_muitas_viagens(): void
    {
        $vehicle = Vehicle::factory()->create();
        $trip1 = Trip::factory()->create(['vehicle_id' => $vehicle->id]);
        $trip2 = Trip::factory()->create(['vehicle_id' => $vehicle->id]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $vehicle->trips);
        $this->assertCount(2, $vehicle->trips);
        $this->assertTrue($vehicle->trips->contains($trip1));
        $this->assertTrue($vehicle->trips->contains($trip2));
    }

    /**
     * Testa atributos booleanos do veículo.
     */
    public function test_atributos_booleanos_veiculo(): void
    {
        $vehicle = Vehicle::factory()->create([
            'has_internet' => true,
            'has_wc' => false,
            'has_power_outlet' => true,
            'has_ac' => false,
            'has_fridge' => true,
            'has_heating' => false,
            'has_video' => true,
        ]);

        $this->assertTrue($vehicle->has_internet);
        $this->assertFalse($vehicle->has_wc);
        $this->assertTrue($vehicle->has_power_outlet);
        $this->assertFalse($vehicle->has_ac);
        $this->assertTrue($vehicle->has_fridge);
        $this->assertFalse($vehicle->has_heating);
        $this->assertTrue($vehicle->has_video);
    }

    /**
     * Testa validação de capacidade do veículo.
     */
    public function test_capacidade_veiculo_e_inteiro(): void
    {
        $vehicle = Vehicle::factory()->create(['capacity' => 45]);

        $this->assertIsInt($vehicle->capacity);
        $this->assertEquals(45, $vehicle->capacity);
    }

    /**
     * Testa validação de ano do veículo.
     */
    public function test_ano_veiculo_e_inteiro(): void
    {
        $vehicle = Vehicle::factory()->create(['year' => 2023]);

        $this->assertIsInt($vehicle->year);
        $this->assertEquals(2023, $vehicle->year);
    }

    /**
     * Testa unicidade do prefixo do veículo.
     */
    public function test_prefixo_veiculo_deve_ser_unico(): void
    {
        Vehicle::factory()->create(['prefix' => 'AQ']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Vehicle::factory()->create(['prefix' => 'AQ']);
    }
}
