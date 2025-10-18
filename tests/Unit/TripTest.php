<?php

namespace Tests\Unit;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Constants\Trip as TripConstants;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class TripTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa criação de viagem com dados válidos.
     */
    public function test_pode_criar_viagem_com_dados_validos(): void
    {
        $vehicle = Vehicle::factory()->create();
        $driver = Driver::factory()->create();

        $tripData = [
            'name' => 'Viagem para São Paulo',
            'status' => TripConstants::STATUS_IN_PROGRESS,
            'departure_date' => '2024-12-25',
            'departure_time' => '08:00',
            'origin' => 'Rio de Janeiro',
            'destination' => 'São Paulo',
            'route' => 'Rio de Janeiro > São Paulo',
            'rules' => 'Não fumar',
            'passenger_price' => 150.00,
            'max_passengers' => 30,
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
        ];

        $trip = Trip::create($tripData);

        $this->assertInstanceOf(Trip::class, $trip);
        $this->assertEquals('Viagem para São Paulo', $trip->name);
        $this->assertEquals(TripConstants::STATUS_IN_PROGRESS, $trip->status);
        $this->assertEquals('Rio de Janeiro', $trip->origin);
        $this->assertEquals('São Paulo', $trip->destination);
        $this->assertEquals(150.00, $trip->passenger_price);
        $this->assertEquals(30, $trip->max_passengers);

        $this->assertDatabaseHas('trips', [
            'name' => 'Viagem para São Paulo',
            'origin' => 'Rio de Janeiro',
            'destination' => 'São Paulo',
        ]);
    }

    /**
     * Testa atributos fillable da viagem.
     */
    public function test_viagem_tem_atributos_fillable_corretos(): void
    {
        $trip = new Trip();
        $expectedFillable = [
            'name',
            'status',
            'departure_date',
            'departure_time',
            'origin',
            'destination',
            'route',
            'rules',
            'passenger_price',
            'max_passengers',
            'vehicle_id',
            'driver_id',
        ];

        $this->assertEquals($expectedFillable, $trip->getFillable());
    }

    /**
     * Testa casts da viagem.
     */
    public function test_viagem_tem_casts_corretos(): void
    {
        $trip = new Trip();
        $casts = $trip->getCasts();

        $this->assertArrayHasKey('departure_date', $casts);
        $this->assertArrayHasKey('departure_time', $casts);
        $this->assertArrayHasKey('passenger_price', $casts);
        $this->assertArrayHasKey('max_passengers', $casts);
        $this->assertEquals('date', $casts['departure_date']);
        $this->assertEquals('datetime:H:i', $casts['departure_time']);
        $this->assertEquals('decimal:2', $casts['passenger_price']);
        $this->assertEquals('integer', $casts['max_passengers']);
    }

    /**
     * Testa relacionamento viagem pertence a veículo.
     */
    public function test_viagem_pertence_ao_veiculo(): void
    {
        $vehicle = Vehicle::factory()->create();
        $trip = Trip::factory()->create(['vehicle_id' => $vehicle->id]);

        $this->assertInstanceOf(Vehicle::class, $trip->vehicle);
        $this->assertEquals($vehicle->id, $trip->vehicle->id);
    }

    /**
     * Testa relacionamento viagem pertence a motorista.
     */
    public function test_viagem_pertence_ao_motorista(): void
    {
        $driver = Driver::factory()->create();
        $trip = Trip::factory()->create(['driver_id' => $driver->id]);

        $this->assertInstanceOf(Driver::class, $trip->driver);
        $this->assertEquals($driver->id, $trip->driver->id);
    }

    /**
     * Testa se a rota é gerada automaticamente.
     */
    public function test_rota_e_gerada_automaticamente(): void
    {
        $trip = Trip::factory()->create([
            'origin' => 'Rio de Janeiro',
            'destination' => 'São Paulo',
        ]);

        $this->assertEquals('Rio de Janeiro > São Paulo', $trip->route);

        // Test updating origin
        $trip->update(['origin' => 'Belo Horizonte']);
        $this->assertEquals('Belo Horizonte > São Paulo', $trip->fresh()->route);

        // Test updating destination
        $trip->update(['destination' => 'Brasília']);
        $this->assertEquals('Belo Horizonte > Brasília', $trip->fresh()->route);
    }

    /**
     * Testa scope por status.
     */
    public function test_scope_por_status(): void
    {
        Trip::factory()->create(['status' => TripConstants::STATUS_IN_PROGRESS]);
        Trip::factory()->create(['status' => TripConstants::STATUS_COMPLETED]);
        Trip::factory()->create(['status' => TripConstants::STATUS_CANCELLED]);

        $inProgressTrips = Trip::byStatus(TripConstants::STATUS_IN_PROGRESS)->get();
        $completedTrips = Trip::byStatus(TripConstants::STATUS_COMPLETED)->get();
        $cancelledTrips = Trip::byStatus(TripConstants::STATUS_CANCELLED)->get();

        $this->assertCount(1, $inProgressTrips);
        $this->assertCount(1, $completedTrips);
        $this->assertCount(1, $cancelledTrips);
    }

    /**
     * Testa scope em andamento.
     */
    public function test_scope_em_andamento(): void
    {
        Trip::factory()->create(['status' => TripConstants::STATUS_IN_PROGRESS]);
        Trip::factory()->create(['status' => TripConstants::STATUS_COMPLETED]);

        $inProgressTrips = Trip::inProgress()->get();

        $this->assertCount(1, $inProgressTrips);
        $this->assertEquals(TripConstants::STATUS_IN_PROGRESS, $inProgressTrips->first()->status);
    }

    /**
     * Testa scope completa.
     */
    public function test_scope_completa(): void
    {
        Trip::factory()->create(['status' => TripConstants::STATUS_IN_PROGRESS]);
        Trip::factory()->create(['status' => TripConstants::STATUS_COMPLETED]);

        $completedTrips = Trip::completed()->get();

        $this->assertCount(1, $completedTrips);
        $this->assertEquals(TripConstants::STATUS_COMPLETED, $completedTrips->first()->status);
    }

    /**
     * Testa scope cancelada.
     */
    public function test_scope_cancelada(): void
    {
        Trip::factory()->create(['status' => TripConstants::STATUS_IN_PROGRESS]);
        Trip::factory()->create(['status' => TripConstants::STATUS_CANCELLED]);

        $cancelledTrips = Trip::cancelled()->get();

        $this->assertCount(1, $cancelledTrips);
        $this->assertEquals(TripConstants::STATUS_CANCELLED, $cancelledTrips->first()->status);
    }

    /**
     * Testa accessor data e hora de partida formatada.
     */
    public function test_accessor_data_hora_partida_formatada(): void
    {
        $trip = Trip::factory()->create([
            'departure_date' => '2024-12-25',
            'departure_time' => '08:00',
        ]);

        $this->assertEquals('25/12/2024 às 08:00', $trip->formatted_departure_date_time);
    }


    /**
     * Testa accessor status em português.
     */
    public function test_accessor_status_em_portugues(): void
    {
        $tripInProgress = Trip::factory()->create(['status' => TripConstants::STATUS_IN_PROGRESS]);
        $tripCompleted = Trip::factory()->create(['status' => TripConstants::STATUS_COMPLETED]);
        $tripCancelled = Trip::factory()->create(['status' => TripConstants::STATUS_CANCELLED]);

        $this->assertEquals('Em andamento', $tripInProgress->status_in_portuguese);
        $this->assertEquals('Completa', $tripCompleted->status_in_portuguese);
        $this->assertEquals('Cancelada', $tripCancelled->status_in_portuguese);
    }


    /**
     * Testa soft delete da viagem.
     */
    public function test_soft_delete_viagem(): void
    {
        $trip = Trip::factory()->create();

        $this->assertNull($trip->deleted_at);

        $trip->delete();

        $this->assertSoftDeleted('trips', ['id' => $trip->id]);
        $this->assertNotNull($trip->fresh()->deleted_at);
    }

    /**
     * Testa preço do passageiro é decimal.
     */
    public function test_preco_passageiro_e_decimal(): void
    {
        $trip = Trip::factory()->create(['passenger_price' => 150.75]);

        $this->assertIsNumeric($trip->passenger_price);
        $this->assertEquals(150.75, $trip->passenger_price);
    }

    /**
     * Testa máximo de passageiros é inteiro.
     */
    public function test_maximo_passageiros_e_inteiro(): void
    {
        $trip = Trip::factory()->create(['max_passengers' => 45]);

        $this->assertIsInt($trip->max_passengers);
        $this->assertEquals(45, $trip->max_passengers);
    }
}
