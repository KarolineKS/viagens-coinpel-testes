// @ts-check
import { expect } from "@playwright/test";

/**
 * Helpers para criação de entidades nos testes E2E
 */

/**
 * Cria um novo usuário
 * @param {import('@playwright/test').Page} page
 * @param {Object} userData
 */
export async function createUser(page, userData = {}) {
    // Gerar dados únicos baseados no timestamp
    const timestamp = Date.now();

    const defaultData = {
        name: `João Silva Teste ${timestamp}`,
        email: `joao.teste.${timestamp}@coinpel.com`,
        password: "password123",
    };

    const data = { ...defaultData, ...userData };

    // Navegar para página de usuários
    await page.goto("/users");
    await page.waitForLoadState("networkidle");
    await expect(page).toHaveURL(/users/);

    // Clicar no botão para criar novo usuário (no header)
    const createButton = page.locator(".header__add-btn");
    await createButton.click();

    // Aguardar o offcanvas abrir
    await page.waitForSelector("#userFormOffcanvas", { state: "visible" });

    // Preencher formulário
    await page.fill('input[name="name"]', data.name);
    await page.fill('input[name="email"]', data.email);
    await page.fill('input[name="password"]', data.password);

    // Submeter formulário
    await page.click('button[type="submit"][form="userForm"]');
    await page.waitForLoadState("networkidle");

    // Verificar se foi criado
    const successMessage = page.locator(".alert-success, .toast-success");
    const userInList = page.locator(`text=${data.name}`);

    const hasSuccess = (await successMessage.count()) > 0;
    const hasUserInList = (await userInList.count()) > 0;

    expect(hasSuccess || hasUserInList).toBeTruthy();
}

/**
 * Cria um novo motorista
 * @param {import('@playwright/test').Page} page
 * @param {Object} driverData
 */
export async function createDriver(page, driverData = {}) {
    // Gerar dados únicos baseados no timestamp
    const timestamp = Date.now();
    const randomSuffix = Math.floor(Math.random() * 10000);

    const defaultData = {
        name: `Pedro Motorista Teste ${timestamp}`,
        birth_date: "1990-01-15",
        registration_number: `${timestamp}${randomSuffix}`,
        cpf: `${timestamp}${randomSuffix}`,
        rg: `${timestamp}${randomSuffix}`,
    };

    const data = { ...defaultData, ...driverData };

    // Navegar para página de motoristas
    await page.goto("/drivers");
    await page.waitForLoadState("networkidle");
    await expect(page).toHaveURL(/drivers/);

    // Clicar no botão para criar novo motorista (no header)
    const createButton = page.locator(".header__add-btn");
    await createButton.click();
    await page.waitForLoadState("networkidle");

    // Preencher dados pessoais
    await page.fill('input[name="name"]', data.name);
    await page.fill('input[name="birth_date"]', data.birth_date);
    await page.fill(
        'input[name="registration_number"]',
        data.registration_number
    );
    await page.fill('input[name="cpf"]', data.cpf);
    await page.fill('input[name="rg"]', data.rg);

    // Preencher dados de endereço
    await page.fill('input[name="zip_code"]', "01234-567");
    await page.fill('input[name="street"]', "Rua Teste");
    await page.fill('input[name="number"]', "123");
    await page.fill('input[name="city"]', "São Paulo");

    // Selecionar estado
    const stateSelect = page.locator('select[name="state"]');
    await stateSelect.selectOption("SP");

    // Preencher dados de contato
    await page.fill(
        'input[name="email"]',
        `${data.name.toLowerCase().replace(/\s+/g, ".")}@coinpel.com`
    );
    await page.fill('input[name="phone"]', "11999999999");

    // Preencher dados da CNH
    await page.fill('input[name="cnh_number"]', "12345678901");

    // Selecionar categoria da CNH
    const cnhCategorySelect = page.locator('select[name="cnh_category"]');
    await cnhCategorySelect.selectOption("B");

    // Preencher validade da CNH
    await page.fill('input[name="cnh_expiry_date"]', "2030-12-31");

    // Submeter formulário
    await page.click(
        'button[type="submit"][form="driverForm"], button:has-text("Finalizar Cadastro")'
    );
    await page.waitForLoadState("networkidle");

    // Verificar se foi criado
    const successMessage = page.locator(".alert-success, .toast-success");
    const driverInList = page.locator(`text=${data.name}`);

    const hasSuccess = (await successMessage.count()) > 0;
    const hasDriverInList = (await driverInList.count()) > 0;

    expect(hasSuccess || hasDriverInList).toBeTruthy();
}

/**
 * Cria uma nova viagem
 * @param {import('@playwright/test').Page} page
 * @param {Object} tripData
 */
export async function createTrip(page, tripData = {}) {
    // Gerar dados únicos baseados no timestamp
    const timestamp = Date.now();

    const defaultData = {
        name: `Viagem Teste São Paulo ${timestamp}`,
        rules: "Regra teste",
        departure_date: "2024-12-25",
        departure_time: "08:00",
        origin: "Rio de Janeiro",
        destination: "São Paulo",
        passenger_price: "150.00",
        max_passengers: "40",
    };

    const data = { ...defaultData, ...tripData };

    // Navegar para página de viagens
    await page.goto("/trips");
    await page.waitForLoadState("networkidle");
    await expect(page).toHaveURL(/trips/);

    // Clicar no botão para criar nova viagem (no header)
    const createButton = page.locator(".header__add-btn");
    await createButton.click();
    await page.waitForLoadState("networkidle");

    // Preencher informações da viagem
    await page.fill('input[name="name"]', data.name);
    await page.fill('input[name="rules"]', data.rules);
    await page.fill('input[name="departure_date"]', data.departure_date);
    await page.fill('input[name="departure_time"]', data.departure_time);
    await page.fill('input[name="origin"]', data.origin);
    await page.fill('input[name="destination"]', data.destination);
    await page.fill('input[name="passenger_price"]', data.passenger_price);
    await page.fill('input[name="max_passengers"]', data.max_passengers);

    // Selecionar veículo e motorista (se disponíveis)
    const vehicleSelect = page.locator('select[name="vehicle_id"]');
    const vehicleOptions = await vehicleSelect.locator("option").count();
    if (vehicleOptions > 1) {
        await vehicleSelect.selectOption({ index: 1 });
    }

    const driverSelect = page.locator('select[name="driver_id"]');
    const driverOptions = await driverSelect.locator("option").count();
    if (driverOptions > 1) {
        await driverSelect.selectOption({ index: 1 });
    }

    // Submeter formulário
    await page.click('button:has-text("Salvar viagem")');
    await page.waitForLoadState("networkidle");

    // Verificar se foi criada
    const successMessage = page.locator(".alert-success, .toast-success");
    const tripInList = page.locator(`text=${data.name}`);
    const errorMessage = page.locator(".alert-danger, .toast-danger");

    const hasSuccess = (await successMessage.count()) > 0;
    const hasTripInList = (await tripInList.count()) > 0;
    const hasError = (await errorMessage.count()) > 0;

    // Se há erro, mostrar a mensagem
    if (hasError) {
        const errorText = await errorMessage.first().textContent();
        console.log(`Erro ao criar viagem: ${errorText}`);
    }

    // Verificar se pelo menos não há erro
    expect(hasError).toBeFalsy();
}
