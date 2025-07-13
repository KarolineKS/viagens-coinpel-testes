<x-offcanvas id="vehicleFormOffcanvas" title="Veículo">
    <x-slot name="body">
        <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">


            <div class="form-group">
                <label for="identification_name" class="form-group__label">Nome de identificação:</label>
                <input type="text" class="form-group__input" id="identification_name" name="identification_name" required>
            </div>

            <div class="form-group">
                <label for="prefix" class="form-group__label">Prefixo:</label>
                <input type="text" class="form-group__input" id="prefix" name="prefix" required>
            </div>

            <div class="form-group">
                <label for="license_plate" class="form-group__label">Placa:</label>
                <input type="text" class="form-group__input" id="license_plate" name="license_plate" required>
            </div>

            <div class="form-group">
                <label for="model" class="form-group__label">Modelo:</label>
                <input type="text" class="form-group__input" id="model" name="model" required>
            </div>

            <div class="form-group">
                <label for="chassis" class="form-group__label">Chassi:</label>
                <input type="text" class="form-group__input" id="chassis" name="chassis" required>
            </div>

            <div class="form-group">
                <label for="capacity" class="form-group__label">Capacidade:</label>
                <input type="number" class="form-group__input" id="capacity" name="capacity" required>
            </div>

            <div class="form-group">
                <label for="vehicle_type" class="form-group__label">Tipo de ônibus:</label>
                <input type="text" class="form-group__input" id="vehicle_type" name="vehicle_type" required>
            </div>

            <div class="form-group">
                <label for="seating_layout" class="form-group__label">Bancada:</label>
                <select class="form-group__select" id="seating_layout" name="seating_layout" required>
                    <option value="Semi-Leito" selected>Semi-Leito</option>
                    <option value="Leito">Leito</option>
                    <option value="Convencional">Convencional</option>
                </select>
            </div>

            <div class="form-group">
                <label for="year" class="form-group__label">Ano:</label>
                <input type="number" class="form-group__input" id="year" name="year" required min="1900" max="{{ date('Y') + 1 }}">
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_internet" value="has_internet" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_internet">
                        <x-icon name="wifi" class="me-2" />
                        Internet
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_wc" value="has_wc" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_wc">
                        <x-icon name="wc" class="me-2" />
                        WC
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_power_outlet" value="has_power_outlet" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_power_outlet">
                        <x-icon name="plug" class="me-2" />
                        Tomada
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_ac" value="has_ac" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_ac">
                        <x-icon name="ac" class="me-2" />
                        Ar Condicionado
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_fridge" value="has_fridge" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_fridge">
                        <x-icon name="fridge" class="me-2" />
                        Geladeira
                    </label>
                </div>
                <div class="col-6">
                    <input type="checkbox" class="btn-check" name="amenities[]" id="has_heating" value="has_heating" autocomplete="off">
                    <label class="amenity-btn w-100" for="has_heating">
                        <x-icon name="heating" class="me-2" />
                        Calefação
                    </label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="col-6">
                        <input type="checkbox" class="btn-check" name="amenities[]" id="has_video" value="has_video" autocomplete="off">
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
            Finalizar cadastro
        </button>
        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
    </x-slot>
</x-offcanvas>