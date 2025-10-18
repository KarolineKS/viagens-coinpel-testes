// @ts-check
import { test, expect } from "@playwright/test";
import { loginAsAdmin } from "./helpers/auth.js";
import { createUser, createDriver, createTrip } from "./helpers/entities.js";

/**
 * Testes de Criação de Entidades - Sistema Coinpel
 */

test.describe("Criação de Entidades", () => {
    test.beforeEach(async ({ page }) => {
        await loginAsAdmin(page);
    });

    test("deve criar um novo usuário", async ({ page }) => {
        await createUser(page, {
            name: "João Silva Teste",
            email: "joao.teste@coinpel.com",
            password: "password123"
        });
    });

    test("deve criar um novo motorista", async ({ page }) => {
        await createDriver(page, {
            name: "Pedro Motorista Teste",
            birth_date: "1990-01-15",
            registration_number: "12345",
            cpf: "12345678901",
            rg: "123456789"
        });
    });

    test("deve criar uma nova viagem", async ({ page }) => {
        await createTrip(page, {
            name: "Viagem Teste São Paulo",
            rules: "Regra teste",
            departure_date: "2024-12-25",
            departure_time: "08:00",
            origin: "Rio de Janeiro",
            destination: "São Paulo",
            passenger_price: "150.00",
            max_passengers: "40"
        });
    });
});
