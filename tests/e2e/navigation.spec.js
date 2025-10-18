// @ts-check
import { test, expect } from "@playwright/test";
import { loginAsAdmin } from "./helpers/auth.js";
import { navigateToPage, verifyPageHasContent } from "./helpers/navigation.js";

/**
 * Testes de Navegação - Sistema Coinpel
 */

test.describe("Navegação", () => {
    test.beforeEach(async ({ page }) => {
        await loginAsAdmin(page);
    });

    test("deve navegar para usuários", async ({ page }) => {
        await navigateToPage(page, "/users");
    });

    test("deve navegar para motoristas", async ({ page }) => {
        await navigateToPage(page, "/drivers");
    });

    test("deve navegar para veículos", async ({ page }) => {
        await navigateToPage(page, "/vehicles");
    });

    test("deve navegar para viagens", async ({ page }) => {
        await navigateToPage(page, "/trips");
    });

    test("deve mostrar dashboard inicial", async ({ page }) => {
        await navigateToPage(page, "/dashboard");
        // Verificar se há o título específico do dashboard
        await expect(page.locator("h1")).toContainText(
            "Gerenciamento de viagens - Coinpel"
        );
    });

    test("deve navegar para todas as páginas principais", async ({ page }) => {
        const pages = [
            { url: "/users" },
            { url: "/drivers" },
            { url: "/vehicles" },
            { url: "/trips" },
        ];

        for (const pageInfo of pages) {
            await page.goto(pageInfo.url);
            await page.waitForLoadState("networkidle");
            await expect(page).toHaveURL(pageInfo.url);
            await verifyPageHasContent(page);
        }
    });
});
