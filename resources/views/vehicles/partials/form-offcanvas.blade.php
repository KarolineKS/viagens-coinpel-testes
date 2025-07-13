<x-offcanvas id="vehicleFormOffcanvas"
    title="{{ isset($editVehicle) ? 'Editar veículo' : 'Novo veículo' }}"
    :autoOpen="$autoOpen ?? false"
    :showDeleteBtn="isset($editVehicle)"
    :deleteRoute="isset($editVehicle) ? route('vehicles.destroy', $editVehicle) : null"
    :isEdit="isset($editVehicle)">
    <x-slot name="body">
        <form id="vehicleForm"
            action="{{ isset($editVehicle) ? route('vehicles.update', $editVehicle) : route('vehicles.store') }}"
            method="POST">

            @csrf

            @if(isset($editVehicle))
            @method('PUT')
            @endif


            <div class="form-group">
                <label for="identification_name" class="form-group__label">Nome de identificação:</label>
                <input type="text" class="form-group__input" id="identification_name" name="identification_name"
                    value="{{ old('identification_name', isset($editVehicle) ? $editVehicle->identification_name : '') }}" required>
            </div>

            <div class="form-group">
                <label for="prefix" class="form-group__label">Prefixo:</label>
                <input type="text" class="form-group__input" id="prefix" name="prefix"
                    value="{{ old('prefix', isset($editVehicle) ? $editVehicle->prefix : '') }}" required>
            </div>

            <div class="form-group">
                <label for="license_plate" class="form-group__label">Placa:</label>
                <input type="text" class="form-group__input" id="license_plate" name="license_plate"
                    value="{{ old('license_plate', isset($editVehicle) ? $editVehicle->license_plate : '') }}" required>
            </div>

            <div class="form-group">
                <label for="model" class="form-group__label">Modelo:</label>
                <input type="text" class="form-group__input" id="model" name="model"
                    value="{{ old('model', isset($editVehicle) ? $editVehicle->model : '') }}" required>
            </div>

            <div class="form-group">
                <label for="chassis" class="form-group__label">Chassi:</label>
                <input type="text" class="form-group__input" id="chassis" name="chassis"
                    value="{{ old('chassis', isset($editVehicle) ? $editVehicle->chassis : '') }}" required>
            </div>

            <div class="form-group">
                <label for="capacity" class="form-group__label">Capacidade:</label>
                <input type="number" class="form-group__input" id="capacity" name="capacity"
                    value="{{ old('capacity', isset($editVehicle) ? $editVehicle->capacity : '') }}" required>
            </div>

            <div class="form-group">
                <label for="vehicle_type" class="form-group__label">Tipo de ônibus:</label>
                <input type="text" class="form-group__input" id="vehicle_type" name="vehicle_type"
                    value="{{ old('vehicle_type', isset($editVehicle) ? $editVehicle->vehicle_type : '') }}" required>
            </div>

            <div class="form-group">
                <label for="seating_layout" class="form-group__label">Bancada:</label>
                <select class="form-group__select" id="seating_layout" name="seating_layout" required>
                    @php
                    $selectedSeating = old('seating_layout', isset($editVehicle) ? $editVehicle->seating_layout : 'Semi-Leito');
                    @endphp
                    <option value="Semi-Leito" {{ $selectedSeating == 'Semi-Leito' ? 'selected' : '' }}>Semi-Leito</option>
                    <option value="Leito" {{ $selectedSeating == 'Leito' ? 'selected' : '' }}>Leito</option>
                    <option value="Convencional" {{ $selectedSeating == 'Convencional' ? 'selected' : '' }}>Convencional</option>
                </select>
            </div>

            <div class="form-group">
                <label for="year" class="form-group__label">Ano:</label>
                <input type="number" class="form-group__input" id="year" name="year"
                    value="{{ old('year', isset($editVehicle) ? $editVehicle->year : '') }}"
                    required min="1900" max="{{ date('Y') + 1 }}">
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_internet" value="has_internet"
                        {{ (isset($editVehicle) && $editVehicle->has_internet) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_internet">
                        <x-icon name="wifi" class="me-2" />
                        Internet
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_wc" value="has_wc"
                        {{ (isset($editVehicle) && $editVehicle->has_wc) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_wc">
                        <x-icon name="wc" class="me-2" />
                        WC
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_power_outlet" value="has_power_outlet"
                        {{ (isset($editVehicle) && $editVehicle->has_power_outlet) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_power_outlet">
                        <x-icon name="plug" class="me-2" />
                        Tomada
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_ac" value="has_ac"
                        {{ (isset($editVehicle) && $editVehicle->has_ac) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_ac">
                        <x-icon name="ac" class="me-2" />
                        Ar Condicionado
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_fridge" value="has_fridge"
                        {{ (isset($editVehicle) && $editVehicle->has_fridge) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_fridge">
                        <x-icon name="fridge" class="me-2" />
                        Geladeira
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_heating" value="has_heating"
                        {{ (isset($editVehicle) && $editVehicle->has_heating) ? 'checked' : '' }} autocomplete="off">
                    <label class="amenity-btn w-100" for="has_heating">
                        <x-icon name="heating" class="me-2" />
                        Calefação
                    </label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="col-6">
                        <input type="checkbox" class="btn-check" name="amenities[]" id="has_video" value="has_video"
                            {{ (isset($editVehicle) && $editVehicle->has_video) ? 'checked' : '' }} autocomplete="off">
                        <label class="amenity-btn w-100" for="has_video">
                            <x-icon name="video" class="me-2" />
                            Vídeo
                        </label>
                    </div>
                </div>
            </div>

        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="submit" form="vehicleForm" class="btn btn-primary w-100">
            {{ isset($editVehicle) ? 'Atualizar veículo' : 'Finalizar cadastro' }}
        </button>
        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
    </x-slot>
</x-offcanvas>