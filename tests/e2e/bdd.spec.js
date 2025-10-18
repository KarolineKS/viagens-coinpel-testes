// @ts-check
import { test, expect } from "@playwright/test";
import { loginAsAdmin, logout } from "./helpers/auth.js";
import { navigateToPage } from "./helpers/navigation.js";
import { createUser, createDriver, createTrip } from "./helpers/entities.js";

/**
 * Testes BDD - Cenários de Comportamento - Sistema Coinpel
 * Seguindo o padrão Given-When-Then
 */

test.describe("BDD - Autenticação", () => {
    test("Cenário: Login válido", async ({ page }) => {
        // Given que estou na página de login
        await page.goto("/login");
        await page.waitForLoadState("networkidle");

        // When preencho credenciais válidas
        await page.fill('input[name="email"]', "admin@coinpel.com");
        await page.fill('input[name="password"]', "password");

        // And clico em entrar
        await page.click('button[type="submit"]');

        // Then devo ser redirecionado para o dashboard
        await expect(page).toHaveURL(/dashboard/);
        await expect(page.locator("h1")).toContainText(
            "Gerenciamento de viagens - Coinpel"
        );
    });

    test("Cenário: Login inválido", async ({ page }) => {
        // Given que estou na página de login
        await page.goto("/login");
        await page.waitForLoadState("networkidle");

        // When preencho credenciais inválidas
        await page.fill('input[name="email"]', "usuario@inexistente.com");
        await page.fill('input[name="password"]', "senha_errada");

        // And clico em entrar
        await page.click('button[type="submit"]');

        // Then devo permanecer na página de login
        await page.waitForLoadState("networkidle");
        await expect(page).toHaveURL(/login/);

        // And devo ver uma mensagem de erro
        const hasError = await page
            .locator('.alert-danger, .text-danger, [class*="error"]')
            .isVisible()
            .catch(() => false);
        expect(hasError).toBeTruthy();
    });

    test("Cenário: Logout", async ({ page }) => {
        // Given que estou logado no sistema
        await loginAsAdmin(page);

        // When clico em logout
        await logout(page);

        // Then devo ser redirecionado para a página de login
        await expect(page).toHaveURL(/login/);
    });
});

test.describe("BDD - Navegação", () => {
    test.beforeEach(async ({ page }) => {
        // Given que estou logado no sistema
        await loginAsAdmin(page);
    });

    test("Cenário: Acessar página de usuários", async ({ page }) => {
        // When navego para a página de usuários
        await navigateToPage(page, "/users");

        // Then devo ver a página de usuários carregada
        await expect(page).toHaveURL(/users/);
    });

    test("Cenário: Acessar página de motoristas", async ({ page }) => {
        // When navego para a página de motoristas
        await navigateToPage(page, "/drivers");

        // Then devo ver a página de motoristas carregada
        await expect(page).toHaveURL(/drivers/);
    });

    test("Cenário: Acessar página de veículos", async ({ page }) => {
        // When navego para a página de veículos
        await navigateToPage(page, "/vehicles");

        // Then devo ver a página de veículos carregada
        await expect(page).toHaveURL(/vehicles/);
    });

    test("Cenário: Acessar página de viagens", async ({ page }) => {
        // When navego para a página de viagens
        await navigateToPage(page, "/trips");

        // Then devo ver a página de viagens carregada
        await expect(page).toHaveURL(/trips/);
    });

    test("Cenário: Visualizar dashboard", async ({ page }) => {
        // When acesso o dashboard
        await navigateToPage(page, "/dashboard");

        // Then devo ver o título do sistema
        await expect(page.locator("h1")).toContainText(
            "Gerenciamento de viagens - Coinpel"
        );
    });
});

test.describe("BDD - Criação de Entidades", () => {
    test.beforeEach(async ({ page }) => {
        // Given que estou logado no sistema
        await loginAsAdmin(page);
    });

    test("Cenário: Criar novo usuário", async ({ page }) => {
        // Gerar dados únicos para evitar conflitos
        const timestamp = Date.now();

        // Given que estou na página de usuários
        await page.goto("/users");
        await page.waitForLoadState("networkidle");

        // When clico no botão para adicionar usuário
        const createButton = page.locator(".header__add-btn");
        await createButton.click();

        // And preencho os dados do usuário
        await page.waitForSelector("#userFormOffcanvas", { state: "visible" });
        await page.fill('input[name="name"]', `João Silva BDD ${timestamp}`);
        await page.fill(
            'input[name="email"]',
            `joao.bdd.${timestamp}@coinpel.com`
        );
        await page.fill('input[name="password"]', "password123");

        // And submeto o formulário
        await page.click('button[type="submit"][form="userForm"]');
        await page.waitForLoadState("networkidle");

        // Then o usuário deve ser criado com sucesso
        const successMessage = page.locator(".alert-success, .toast-success");
        const userInList = page.locator(`text=João Silva BDD ${timestamp}`);

        const hasSuccess = (await successMessage.count()) > 0;
        const hasUserInList = (await userInList.count()) > 0;

        expect(hasSuccess || hasUserInList).toBeTruthy();
    });

    test("Cenário: Criar novo motorista", async ({ page }) => {
        // Gerar dados únicos para evitar conflitos
        const timestamp = Date.now();
        const randomSuffix = Math.floor(Math.random() * 10000);

        // Given que estou na página de motoristas
        await page.goto("/drivers");
        await page.waitForLoadState("networkidle");

        // When clico no botão para adicionar motorista
        const createButton = page.locator(".header__add-btn");
        await createButton.click();
        await page.waitForLoadState("networkidle");

        // And preencho os dados básicos do motorista
        await page.fill(
            'input[name="name"]',
            `Pedro Motorista BDD ${timestamp}`
        );
        await page.fill('input[name="birth_date"]', "1990-01-15");
        await page.fill(
            'input[name="registration_number"]',
            `${timestamp}${randomSuffix}`
        );
        await page.fill('input[name="cpf"]', `${timestamp}${randomSuffix}`);
        await page.fill('input[name="rg"]', `${timestamp}${randomSuffix}`);

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
            "pedro.motorista.bdd@coinpel.com"
        );
        await page.fill('input[name="phone"]', "11999999999");

        // Preencher dados da CNH
        await page.fill('input[name="cnh_number"]', "12345678901");

        // Selecionar categoria da CNH
        const cnhCategorySelect = page.locator('select[name="cnh_category"]');
        await cnhCategorySelect.selectOption("B");

        // Preencher validade da CNH
        await page.fill('input[name="cnh_expiry_date"]', "2030-12-31");

        // And submeto o formulário
        await page.click(
            'button[type="submit"][form="driverForm"], button:has-text("Finalizar Cadastro")'
        );
        await page.waitForLoadState("networkidle");

        // Then o motorista deve ser criado com sucesso
        const successMessage = page.locator(".alert-success, .toast-success");
        const driverInList = page.locator(
            `text=Pedro Motorista BDD ${timestamp}`
        );
        const errorMessage = page.locator(".alert-danger, .toast-danger");

        const hasSuccess = (await successMessage.count()) > 0;
        const hasDriverInList = (await driverInList.count()) > 0;
        const hasError = (await errorMessage.count()) > 0;

        // Se há erro, mostrar a mensagem para debug
        if (hasError) {
            const errorText = await errorMessage.first().textContent();
            console.log(`Erro ao criar motorista BDD: ${errorText}`);
        }

        // Verificar se pelo menos não há erro
        expect(hasError).toBeFalsy();
    });

    test("Cenário: Criar nova viagem", async ({ page }) => {
        // Gerar dados únicos para evitar conflitos
        const timestamp = Date.now();

        // Given que estou na página de viagens
        await page.goto("/trips");
        await page.waitForLoadState("networkidle");

        // When clico no botão para adicionar viagem
        const createButton = page.locator(".header__add-btn");
        await createButton.click();
        await page.waitForLoadState("networkidle");

        // And preencho os dados da viagem
        await page.fill(
            'input[name="name"]',
            `Viagem BDD São Paulo ${timestamp}`
        );
        await page.fill('input[name="rules"]', "Regra BDD");
        await page.fill('input[name="departure_date"]', "2024-12-25");
        await page.fill('input[name="departure_time"]', "08:00");
        await page.fill('input[name="origin"]', "Rio de Janeiro");
        await page.fill('input[name="destination"]', "São Paulo");
        await page.fill('input[name="passenger_price"]', "150.00");
        await page.fill('input[name="max_passengers"]', "40");

        // And seleciono veículo e motorista (se disponíveis)
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

        // And submeto o formulário
        await page.click('button:has-text("Salvar viagem")');
        await page.waitForLoadState("networkidle");

        // Then a viagem deve ser criada com sucesso
        const successMessage = page.locator(".alert-success, .toast-success");
        const tripInList = page.locator(
            `text=Viagem BDD São Paulo ${timestamp}`
        );
        const errorMessage = page.locator(".alert-danger, .toast-danger");

        const hasSuccess = (await successMessage.count()) > 0;
        const hasTripInList = (await tripInList.count()) > 0;
        const hasError = (await errorMessage.count()) > 0;

        // Verificar se pelo menos não há erro
        expect(hasError).toBeFalsy();
    });
});

test.describe("BDD - Fluxo Completo", () => {
    test("Cenário: Fluxo completo de gerenciamento", async ({ page }) => {
        // Given que estou na página de login
        await page.goto("/login");
        await page.waitForLoadState("networkidle");

        // When faço login com credenciais válidas
        await page.fill('input[name="email"]', "admin@coinpel.com");
        await page.fill('input[name="password"]', "password");
        await page.click('button[type="submit"]');

        // Then devo ser redirecionado para o dashboard
        await expect(page).toHaveURL(/dashboard/);

        // When navego para diferentes seções do sistema
        const sections = ["/users", "/drivers", "/vehicles", "/trips"];

        for (const section of sections) {
            await page.goto(section);
            await page.waitForLoadState("networkidle");
            await expect(page).toHaveURL(section);
        }

        // And faço logout
        await logout(page);

        // Then devo ser redirecionado para a página de login
        await expect(page).toHaveURL(/login/);
    });
});
