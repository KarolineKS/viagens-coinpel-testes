<div class="offcanvas offcanvas-end" tabindex="-1" id="vehicleFormOffcanvas" aria-labelledby="vehicleFormOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="vehicleFormOffcanvasLabel">Veículo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="identification_name" class="form-label">Nome de identificação:</label>
                <input type="text" class="form-control" id="identification_name" name="identification_name" required>
            </div>

            <div class="mb-3">
                <label for="prefix" class="form-label">Prefixo:</label>
                <input type="text" class="form-control" id="prefix" name="prefix" required>
            </div>

            <div class="mb-3">
                <label for="license_plate" class="form-label">Placa:</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Modelo:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>

            <div class="mb-3">
                <label for="chassis" class="form-label">Chassi:</label>
                <input type="text" class="form-control" id="chassis" name="chassis" required>
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Capacidade:</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>

            <div class="mb-3">
                <label for="vehicle_type" class="form-label">Tipo de Veículo:</label>
                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" required>
            </div>

            <div class="mb-3">
                <label for="seating_layout" class="form-label">Bancada:</label>
                <select class="form-select" id="seating_layout" name="seating_layout" required>
                    <option value="Semi-Leito" selected>Semi-Leito</option>
                    <option value="Leito">Leito</option>
                    <option value="Convencional">Convencional</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Ano:</label>
                <input type="number" class="form-control" id="year" name="year" required min="1900" max="{{ date('Y') + 1 }}">
            </div>

            <hr class="my-4">

            <h6>Comodidades</h6>
            <div class="row g-2">
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_internet" value="has_internet" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_internet">Internet</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_wc" value="has_wc" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_wc">WC</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_power_outlet" value="has_power_outlet" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_power_outlet">Tomada</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_ac" value="has_ac" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_ac">Ar Condicionado</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_fridge" value="has_fridge" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_fridge">Geladeira</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_heating" value="has_heating" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_heating">Calefação</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="has_video" value="has_video" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="has_video">Vídeo</label></div>
            </div>

        </form>
    </div>
    <div class="offcanvas-footer p-3">
        <button type="submit" form="vehicleForm" class="btn btn-primary w-100 mb-2">Finalizar cadastro</button>
        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
    </div>
</div>