<div class="offcanvas offcanvas-end" tabindex="-1" id="vehicleFormOffcanvas" aria-labelledby="vehicleFormOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="vehicleFormOffcanvasLabel">Veículo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nome_identificacao" class="form-label">Nome de identificação:</label>
                <input type="text" class="form-control" id="nome_identificacao" name="nome_identificacao" required>
            </div>

            <div class="mb-3">
                <label for="placa" class="form-label">Placa:</label>
                <input type="text" class="form-control" id="placa" name="placa" required>
            </div>

            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>

            <div class="mb-3">
                <label for="chassi" class="form-label">Chassi:</label>
                <input type="text" class="form-control" id="chassi" name="chassi" required>
            </div>

            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade:</label>
                <input type="number" class="form-control" id="capacidade" name="capacidade" required>
            </div>

            <div class="mb-3">
                <label for="tipo_onibus" class="form-label">Tipo de ônibus:</label>
                <input type="text" class="form-control" id="tipo_onibus" name="tipo_onibus" required>
            </div>

            <div class="mb-3">
                <label for="bancada" class="form-label">Bancada:</label>
                <select class="form-select" id="bancada" name="bancada" required>
                    <option value="Semi-Leito" selected>Semi-Leito</option>
                    <option value="Leito">Leito</option>
                    <option value="Convencional">Convencional</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="ano" class="form-label">Ano:</label>
                <input type="number" class="form-control" id="ano" name="ano" required min="1900" max="{{ date('Y') + 1 }}">
            </div>

            <hr class="my-4">

            <h6>Comodidades</h6>
            <div class="row g-2">
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="internet" value="internet" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="internet">Internet</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="wc" value="wc" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="wc">WC</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="tomada" value="tomada" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="tomada">Tomada</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="ar_condicionado" value="ar_condicionado" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="ar_condicionado">Ar Condicionado</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="geladeira" value="geladeira" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="geladeira">Geladeira</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="calefacao" value="calefacao" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="calefacao">Calefação</label></div>
                <div class="col-6"><input type="checkbox" class="btn-check" name="amenities[]" id="video" value="video" autocomplete="off"><label class="btn btn-outline-secondary w-100" for="video">Vídeo</label></div>
            </div>

        </form>
    </div>
    <div class="offcanvas-footer p-3">
        <button type="submit" form="vehicleForm" class="btn btn-primary w-100 mb-2">Finalizar cadastro</button>
        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
    </div>
</div>