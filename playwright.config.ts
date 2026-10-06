import {defineConfig} from '@playwright/test';
export default defineConfig({testDir: './tests/E2E', use: {baseURL: process.env.CF_TEST_URL ?? 'http://localhost:8887', headless: true, channel: process.env.CF_BROWSER_CHANNEL}, workers: 1, reporter: 'list'});
