// @ts-check
import { expect } from "@playwright/test";

/**
 * Helpers para autenticação nos testes E2E
 */

/**
 * Faz login como admin
 * @param {import('@playwright/test').Page} page
 */
export async function loginAsAdmin(page) {
    await page.goto("/login");
    await page.waitForLoadState("networkidle");

    await page.fill('input[name="email"]', "admin@coinpel.com");
    await page.fill('input[name="password"]', "password");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL(/dashboard/);
}

/**
 * Faz logout do usuário
 * @param {import('@playwright/test').Page} page
 */
export async function logout(page) {
    // Primeiro, clicar no menu do usuário para abrir o dropdown
    const userMenuButton = page.locator("#userMenuButton");
    await userMenuButton.click();

    // Aguardar o dropdown abrir
    await page.waitForTimeout(500);

    // Procurar pelo botão de logout no dropdown - usar seletor mais específico
    const logoutButton = page.locator(
        '.dropdown-menu form[action*="logout"] button[type="submit"]'
    );
    await logoutButton.click();

    // Aguardar redirecionamento
    await page.waitForLoadState("networkidle");
    await expect(page).toHaveURL(/login/);
}
