import {test, expect} from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
test.beforeEach(async ({page}) => {
  await page.request.get('/wp-login.php'); await page.request.post('/wp-login.php', {form: {log:'admin',pwd:'cf-local-test-password',testcookie:'1','wp-submit':'Log In'}}); await page.goto('/wp-admin/admin.php?page=content-firewall'); await expect(page.getByRole('heading',{name:'Content Firewall',exact:true})).toBeVisible();
});
test('Policy builder validates and saves a nested rule and simulates', async ({page}) => {
  await page.getByRole('button',{name:'Policies',exact:true}).click(); await page.getByRole('button',{name:'Add rule',exact:true}).click(); await page.getByRole('button',{name:'Add nested group',exact:true}).first().click(); await page.getByLabel('Value',{exact:true}).last().fill('avatar'); await page.getByLabel('Synthetic explicit-content score').fill('0.9'); await page.getByRole('button',{name:'Simulate',exact:true}).click(); await expect(page.getByRole('status').last()).toContainText('REVIEW'); await page.getByRole('button',{name:'Save new version',exact:true}).click(); await expect(page.getByRole('status').first()).toContainText('saved');
});
test('Queue exposes safe state and requires reason for moderation', async ({page}) => {
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click(); await expect(page.getByRole('heading',{name:'Moderation queue',exact:true})).toBeVisible(); await expect(page.getByRole('button',{name:'Approve selected'})).toBeDisabled(); await expect(page.getByLabel('Required moderation reason')).toBeVisible();
});
test('Health, diagnostics and admin accessibility', async ({page}) => {
  await page.getByRole('button',{name:'System Health',exact:true}).click(); await expect(page.getByRole('heading',{name:'System Health',exact:true})).toBeVisible(); const results = await new AxeBuilder({page}).include('#cf-app').withTags(['wcag2a','wcag2aa','wcag21aa']).analyze(); expect(results.violations).toEqual([]);
});
test('RTL and keyboard navigation remain usable', async ({page}) => {
  await page.evaluate(() => document.querySelector('#cf-app > div')?.setAttribute('dir','rtl')); await page.getByRole('button',{name:'Policies',exact:true}).focus(); await page.keyboard.press('Enter'); await expect(page.getByRole('heading',{name:'Policies',exact:true})).toBeVisible(); expect(await page.locator('.cf-shell').getAttribute('dir')).toBe('rtl');
});

const routeIs = (path: string) => (url: URL) => (url.searchParams.get('rest_route') ?? url.pathname).endsWith('/content-firewall/v1' + path);
test('Queue reports failed bulk items', async ({page}) => {
  await page.route(routeIs('/scans'), route => route.fulfill({json:[{id:'991',revision:'4',file_name:'fixture.png',state:'REVIEW_REQUIRED',risk:'0.5',created_at:'2026-10-06 00:00:00'}]}));
  await page.route(routeIs('/bulk'), route => route.fulfill({json:[{id:991,error:'QUEUE.STALE_RESULT'}]}));
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click(); await page.getByLabel('Select case 991',{exact:true}).check(); await page.getByLabel('Required moderation reason').fill('Synthetic review reason'); await page.getByRole('button',{name:'Approve selected'}).click(); await expect(page.getByRole('status').first()).toContainText('#991: QUEUE.STALE_RESULT');
});
test('Queue clears selection after changing filters', async ({page}) => {
  await page.route(routeIs('/scans'), route => route.fulfill({json:[{id:'992',revision:'4',file_name:'fixture.png',state:'REVIEW_REQUIRED',risk:'0.5',created_at:'2026-10-06 00:00:00'}]}));
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click(); await page.getByLabel('Select case 992',{exact:true}).check(); await expect(page.getByRole('button',{name:'Approve selected'})).toBeEnabled(); await page.getByLabel('View',{exact:true}).selectOption('BLOCKED'); await expect(page.getByRole('button',{name:'Approve selected'})).toBeDisabled();
});
