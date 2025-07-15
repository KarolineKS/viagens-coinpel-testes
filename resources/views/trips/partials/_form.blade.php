<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="form-title mb-0">Informações da viagem:</h5>

        @if (isset($trip))
        <div class="dropdown status-dropdown-custom">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                id="statusDropdown">
                <span class="status-text">{{ $trip->status_in_portuguese }}</span>
                <span class="status-divider"></span>
                <svg class="status-arrow-icon" xmlns="http://www.w3.org/2000/svg" width="19" height="12" viewBox="0 0 19 12" fill="none">
                    <path d="M1 1L9.5 10L18 1" stroke="white" stroke-width="2" />
                </svg>
            </button>
            <ul class="dropdown-menu">
                <li><button class="dropdown-item status-option" type="button" data-status="in_progress">Em andamento</button></li>
                <li><button class="dropdown-item status-option" type="button" data-status="completed">Concluída</button></li>
                <li><button class="dropdown-item status-option" type="button" data-status="cancelled">Cancelada</button></li>
            </ul>
            <input type="hidden" id="status" name="status" value="{{ old('status', $trip->status ?? 'in_progress') }}">
        </div>
        @else

        <input type="hidden" name="status" value="em_andamento">
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <label for="name" class="form-label">Nome da viagem:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name', $trip->name ?? '') }}" required>
            @error('name')
            <div class=" invalid-feedback">{{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="rules" class="form-label">Regra:</label>
            <input type="text" class="form-control @error('rules') is-invalid @enderror"
                id="rules" name="rules" value="{{ old('rules', $trip->rules ?? '') }}"
                required>
            @error('rules')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="departure_date" class="form-label">Data:</label>
            <input type="date" class="form-control @error('departure_date') is-invalid @enderror"
                id="departure_date" name="departure_date"
                value="{{ old('departure_date', isset($trip) ? $trip->departure_date->format('Y-m-d') : '') }}" required>
            @error('departure_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="departure_time" class="form-label">Horário de Saída:</label>
            <input type="time" class="form-control @error('departure_time') is-invalid @enderror"
                id="departure_time" name="departure_time"
                value="{{ old('departure_time', isset($trip) ? $trip->departure_time->format('H:i') : '') }}" required>
            @error('departure_time')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="origin" class="form-label">Origem:</label>
            <input type="text" class="form-control @error('origin') is-invalid @enderror"
                id="origin" name="origin" value="{{ old('origin', $trip->origin ?? '') }}"
                required>
            @error('origin')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="destination" class="form-label">Destino:</label>
            <input type="text" class="form-control @error('destination') is-invalid @enderror"
                id="destination" name="destination" value="{{ old('destination', $trip->destination ?? '') }}"
                required>
            @error('destination')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="passenger_price" class="form-label">Valor da passagem avulsa:</label>
            <div class="input-group">
                <span class="input-group-text">R$</span>
                <input type="number" class="form-control @error('passenger_price') is-invalid @enderror"
                    id="passenger_price" name="passenger_price"
                    value="{{ old('passenger_price', $trip->passenger_price ?? '') }}"
                    step="0.01" min="0" required>

                @error('passenger_price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    @if (isset($trip))
    @endif

    <div class="my-4">
        <h5 class="form-title mb-3">Dados do veículo:</h5>

        <div class="row">
            <div class="col-md-6">
                <label for="vehicle_id" class="form-label">Veículo:</label>
                <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                    <option value="">Selecione um veículo</option>

                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}"
                        data-capacity="{{ $vehicle->capacity }}"
                        {{ old('vehicle_id', $trip->vehicle_id ?? '') == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->identification_name }} - {{ $vehicle->model }}
                    </option>
                    @endforeach
                </select>

                @error('vehicle_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="max_passengers" class="form-label">Número de passageiros:</label>
                <input type="number" class="form-control @error('max_passengers') is-invalid @enderror"
                    id="max_passengers" name="max_passengers"
                    value="{{ old('max_passengers', $trip->max_passengers ?? '') }}"
                    min="1" required>

                @error('max_passengers')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="form-text" id="vehicle-capacity-text"></div>
            </div>
        </div>
    </div>


    <div class="mb-0">
        <h5 class="form-title mb-3">Motorista:</h5>

        <div class="row">
            <div class="col-md-6">
                <label for="driver_id" class="form-label">Nome:</label>
                <select class="form-select @error('driver_id') is-invalid @enderror" id="driver_id" name="driver_id" required>
                    <option value="">Selecione um motorista</option>
                    @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}"
                        data-registration="{{ $driver->registration_number }}"
                        {{ old('driver_id', $trip->driver_id ?? '') == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }}
                        @if($driver->cnh_expiry_date && $driver->cnh_expiry_date->isPast())
                        (CNH Vencida)
                        @endif
                    </option>
                    @endforeach
                </select>
                @error('driver_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="driver_registration" class="form-label">Matrícula:</label>
                <input type="text" class="form-control" id="driver_registration"
                    value="{{ $trip->driver->registration_number ?? '' }}" readonly>
            </div>
        </div>
    </div>