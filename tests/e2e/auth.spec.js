// @ts-check
import { test, expect } from "@playwright/test";
import { loginAsAdmin, logout } from "./helpers/auth.js";

/**
 * Testes de Autenticação - Sistema Coinpel
 */

test.describe("Autenticação", () => {
    test("deve fazer login com sucesso", async ({ page }) => {
        await page.goto("/login");
        await page.waitForLoadState("networkidle");

        await page.fill('input[name="email"]', "admin@coinpel.com");
        await page.fill('input[name="password"]', "password");
        await page.click('button[type="submit"]');

        await expect(page).toHaveURL(/dashboard/);
        await expect(page.locator("h1")).toContainText(
            "Gerenciamento de viagens - Coinpel"
        );
    });

    test("deve mostrar erro com credenciais inválidas", async ({ page }) => {
        await page.goto("/login");
        await page.waitForLoadState("networkidle");

        await page.fill('input[name="email"]', "usuario@inexistente.com");
        await page.fill('input[name="password"]', "senha_errada");
        await page.click('button[type="submit"]');

        await page.waitForLoadState("networkidle");
        await expect(page).toHaveURL(/login/);

        // Verificar se há mensagem de erro
        const hasError = await page
            .locator('.alert-danger, .text-danger, [class*="error"]')
            .isVisible()
            .catch(() => false);
        expect(hasError).toBeTruthy();
    });

    test("deve fazer logout corretamente", async ({ page }) => {
        await loginAsAdmin(page);
        await logout(page);
    });
});
