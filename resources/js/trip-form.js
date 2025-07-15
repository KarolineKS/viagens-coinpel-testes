document.addEventListener("DOMContentLoaded", function () {
    const vehicleSelect = document.getElementById("vehicle_id");
    const maxPassengersInput = document.getElementById("max_passengers");
    const capacityText = document.getElementById("vehicle-capacity-text");
    const driverSelect = document.getElementById("driver_id");
    const driverRegistrationInput = document.getElementById(
        "driver_registration"
    );

    function updateCapacityText() {
        const selectedOption =
            vehicleSelect.options[vehicleSelect.selectedIndex];
        const capacity = selectedOption.getAttribute("data-capacity");

        if (capacity) {
            maxPassengersInput.max = capacity;
            capacityText.textContent = `Capacidade máxima: ${capacity} passageiros`;
        }
    }

    if (vehicleSelect) {
        vehicleSelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const capacity = selectedOption.getAttribute("data-capacity");

            if (capacity) {
                maxPassengersInput.max = capacity;
                capacityText.textContent = `Capacidade máxima: ${capacity} passageiros`;
            } else {
                capacityText.textContent = "";
                maxPassengersInput.removeAttribute("max");
            }
        });
        updateCapacityText();
    }

    if (driverSelect) {
        driverSelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const registration =
                selectedOption.getAttribute("data-registration");
            driverRegistrationInput.value = registration || "";
        });

        const selectedDriver = driverSelect.options[driverSelect.selectedIndex];
        if (selectedDriver) {
            driverRegistrationInput.value =
                selectedDriver.getAttribute("data-registration") || "";
        }
    }

    const statusInput = document.getElementById("status");
    const statusDropdownBtn = document.getElementById("statusDropdown");
    const statusOptions = document.querySelectorAll(".status-option");

    if (statusInput && statusDropdownBtn && statusOptions.length > 0) {
        const statusClasses = {
            in_progress: "status-in_progress",
            completed: "status-completed",
            cancelled: "status-cancelled",
        };

        function updateStatusButton(status, text) {
            const statusTextElement =
                statusDropdownBtn.querySelector(".status-text");
            if (statusTextElement) {
                // Se o texto não for fornecido, tenta pegar das opções do dropdown
                if (!text) {
                    const option = document.querySelector(
                        `.status-option[data-status="${status}"]`
                    );
                    text = option ? option.textContent : "Selecione";
                }
                statusTextElement.textContent = text;
            }

            // Limpa classes de status anteriores
            Object.values(statusClasses).forEach((className) => {
                statusDropdownBtn.classList.remove(className);
            });

            // Adiciona a classe de status atual
            if (statusClasses[status]) {
                statusDropdownBtn.classList.add(statusClasses[status]);
            }
        }

        statusOptions.forEach((option) => {
            option.addEventListener("click", function () {
                const status = this.getAttribute("data-status");
                const text = this.textContent;
                statusInput.value = status;
                updateStatusButton(status, text);
            });
        });

        // Define o estado inicial da classe de cor. O texto já vem do Blade.
        const initialStatus = statusInput.value;
        if (initialStatus) {
            updateStatusButton(initialStatus);
        }
    }
});
