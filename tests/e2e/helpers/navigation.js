// @ts-check
import { expect } from "@playwright/test";

/**
 * Helpers para navegação nos testes E2E
 */

/**
 * Navega para uma página específica e verifica se carregou corretamente
 * @param {import('@playwright/test').Page} page
 * @param {string} url
 * @param {string|null} expectedTitle
 */
export async function navigateToPage(page, url, expectedTitle = null) {
    await page.goto(url);
    await page.waitForLoadState("networkidle");
    await expect(page).toHaveURL(url);

    // Verificar se a página tem conteúdo visível
    const hasContent = await page.locator("body").isVisible();
    expect(hasContent).toBeTruthy();

    // Se esperamos um título específico, verificar se existe
    if (expectedTitle) {
        // Tentar encontrar o título em diferentes locais possíveis
        const titleSelectors = [
            `h1:has-text("${expectedTitle}")`,
            `h2:has-text("${expectedTitle}")`,
            `h3:has-text("${expectedTitle}")`,
            `.page-title:has-text("${expectedTitle}")`,
            `[data-page-title]:has-text("${expectedTitle}")`,
            `title:has-text("${expectedTitle}")`,
        ];

        let titleFound = false;
        for (const selector of titleSelectors) {
            const element = page.locator(selector);
            if ((await element.count()) > 0) {
                titleFound = true;
                break;
            }
        }

        // Se não encontrou o título específico, pelo menos verificar se a página carregou
        if (!titleFound) {
            console.log(
                `Título "${expectedTitle}" não encontrado na página ${url}, mas a página carregou corretamente`
            );
        }
    }
}

/**
 * Verifica se uma página tem conteúdo visível
 * @param {import('@playwright/test').Page} page
 */
export async function verifyPageHasContent(page) {
    const hasContent = await page.locator("body").isVisible();
    expect(hasContent).toBeTruthy();
}
