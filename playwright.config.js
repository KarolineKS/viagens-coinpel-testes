// @ts-check
import { defineConfig, devices } from "@playwright/test";

/**
 * @see https://playwright.dev/docs/test-configuration
 */
export default defineConfig({
    testDir: "./tests/e2e",
    /* Run tests in files in parallel */
    fullyParallel: true,
    /* Fail the build on CI if you accidentally left test.only in the source code. */
    forbidOnly: !!process.env.CI,
    /* Retry on CI only */
    retries: process.env.CI ? 2 : 1,
    /* Use more workers for faster execution locally */
    workers: process.env.CI ? 1 : 4,
    /* Reporter to use. See https://playwright.dev/docs/test-reporters */
    reporter: [
        ["html"],
        ["json", { outputFile: "test-results/results.json" }],
        ["junit", { outputFile: "test-results/results.xml" }],
    ],
    /* Shared settings for all the projects below. See https://playwright.dev/docs/api/class-testoptions. */
    use: {
        /* Base URL to use in actions like `await page.goto('/')`. */
        baseURL: "http://127.0.0.1:8000",

        /* Collect trace when retrying the failed test. See https://playwright.dev/docs/trace-viewer */
        trace: "on-first-retry",

        /* Take screenshot on failure */
        screenshot: "only-on-failure",

        /* Record video on failure */
        video: "retain-on-failure",

        /* Timeouts otimizados para execução mais rápida */
        actionTimeout: 10000,
        navigationTimeout: 30000,
    },

    /* Configure projects for major browsers - apenas Chromium para desenvolvimento rápido */
    projects: [
        {
            name: "chromium",
            use: { ...devices["Desktop Chrome"] },
        },
        // Descomente os outros browsers quando necessário para testes completos
        // {
        //     name: "firefox",
        //     use: { ...devices["Desktop Firefox"] },
        // },
        // {
        //     name: "webkit",
        //     use: { ...devices["Desktop Safari"] },
        // },
    ],

    /* Run your local dev server before starting the tests */
    webServer: {
        command: "php artisan serve",
        url: "http://127.0.0.1:8000",
        reuseExistingServer: !process.env.CI,
        timeout: 120 * 1000,
    },
});
