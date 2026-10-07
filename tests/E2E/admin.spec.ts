import {test, expect} from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';
test.beforeEach(async ({page}) => {
  await page.request.get('/wp-login.php'); await page.request.post('/wp-login.php', {form: {log:'admin',pwd:'cf-local-test-password',testcookie:'1','wp-submit':'Log In'}}); await page.goto('/wp-admin/admin.php?page=content-firewall',{waitUntil:'domcontentloaded'}); await expect(page.getByRole('heading',{name:'Content Firewall',exact:true})).toBeVisible();
});
test('WordPress lists the canonical entry, serves its assets and guards PHP entrypoints', async ({page}) => {
  for (const file of ['content-firewall.php','includes/autoload.php']) {
    const response=await page.request.get('/wp-content/plugins/content-firewall/'+file);
    expect(response.status()).toBe(200);expect(await response.text()).toBe('');
  }
  for (const file of ['assets/js/admin.js','assets/css/admin.css']) {
    const response=await page.request.get('/wp-content/plugins/content-firewall/'+file);
    expect(response.status()).toBe(200);expect((await response.body()).length).toBeGreaterThan(0);
  }
  await page.goto('/wp-admin/plugins.php');
  const row=page.locator('tr[data-plugin="content-firewall/content-firewall.php"]');
  await expect(row).toBeVisible();await expect(row.locator('.plugin-title strong')).toHaveText('Content Firewall');
  await expect(page.locator('tr[data-plugin="content-firewall/plugin.php"]')).toHaveCount(0);
});
test('Policy builder validates and saves a nested rule and simulates', async ({page}) => {
  await page.getByRole('button',{name:'Policies',exact:true}).click(); await page.getByLabel('Start from a preset').selectOption({label:'Security Only'}); await page.getByRole('button',{name:'Add rule',exact:true}).click(); await page.getByRole('button',{name:'Add nested group',exact:true}).first().click(); await page.getByLabel('Value',{exact:true}).last().fill('avatar'); await page.getByLabel('Synthetic explicit-content score').fill('0.9'); await page.getByRole('button',{name:'Simulate',exact:true}).click(); await expect(page.getByRole('status').last()).toContainText('REVIEW'); await page.getByRole('button',{name:'Save new version',exact:true}).click(); await expect(page.getByRole('status').first()).toContainText('saved');
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
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click(); await page.getByLabel('Select case 991',{exact:true}).check(); await page.getByLabel('Required moderation reason').fill('Synthetic review reason'); await page.getByRole('button',{name:'Approve selected'}).click(); await expect(page.getByRole('dialog')).toBeVisible(); await page.getByRole('button',{name:'Confirm decision',exact:true}).click(); await expect(page.getByRole('status').first()).toContainText('#991: QUEUE.STALE_RESULT');await expect(page.getByRole('heading',{name:'Moderation queue',exact:true})).toBeFocused();
});
test('Queue clears selection after changing filters', async ({page}) => {
  await page.route(routeIs('/scans'), route => route.fulfill({json:[{id:'992',revision:'4',file_name:'fixture.png',state:'REVIEW_REQUIRED',risk:'0.5',created_at:'2026-10-06 00:00:00'}]}));
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click(); await page.getByLabel('Select case 992',{exact:true}).check(); await expect(page.getByRole('button',{name:'Approve selected'})).toBeEnabled(); await page.getByLabel('View',{exact:true}).selectOption('BLOCKED'); await expect(page.getByRole('button',{name:'Approve selected'})).toBeDisabled();
});
test('Uploader can submit a review request without seeing moderator evidence', async ({page}) => {
  await page.route(routeIs('/my-uploads'), route => route.fulfill({json:[{id:'993',state:'BLOCKED',attachment_id:'0',created_at:'2026-10-07 00:00:00',updated_at:'2026-10-07 00:00:00'}]}));
  await page.route(routeIs('/scans/993/appeal'), async route => {expect(route.request().postDataJSON()).toEqual({reason:'Please review this synthetic upload.'}); await route.fulfill({json:{accepted:true}});});
  await page.getByRole('button',{name:'My Uploads',exact:true}).click(); await page.getByRole('button',{name:'Request review',exact:true}).click(); await page.getByLabel('Reason for review').fill('Please review this synthetic upload.'); await page.getByRole('button',{name:'Submit review request',exact:true}).click(); await expect(page.getByRole('status').first()).toContainText('submitted');
});
test('Sensitive API responses prevent caching', async ({page}) => {
  const response = page.waitForResponse(url => routeIs('/health')(new URL(url.url()))); await page.getByRole('button',{name:'System Health',exact:true}).click(); expect((await response).headers()['cache-control']).toContain('no-store');
});
test('Setup resumes saved steps and completes privacy configuration', async ({page}) => {
  const nonce=await page.evaluate(()=>(window as unknown as {CFConfig:{nonce:string}}).CFConfig.nonce);
  const reset=await page.request.post('/?rest_route=/content-firewall/v1/onboarding/save',{headers:{'X-WP-Nonce':nonce},data:{step:0}});expect(reset.ok()).toBe(true);
  await page.getByRole('button',{name:'Setup',exact:true}).click();
  await expect(page.getByRole('heading',{name:'Setup',exact:true})).toBeVisible();
  await page.getByRole('button',{name:'Continue setup',exact:true}).click();
  await page.reload(); await page.getByRole('button',{name:'Setup',exact:true}).click();
  await expect(page.getByLabel('Starting policy')).toBeVisible();
  await page.getByLabel('Starting policy').selectOption('current'); await page.getByRole('button',{name:'Save policy and continue',exact:true}).click();
  await page.getByLabel('Audit events (days)',{exact:true}).fill('100'); await page.getByRole('button',{name:'Save limits and continue',exact:true}).click();
  await page.getByRole('button',{name:'Finish setup',exact:true}).click(); await expect(page.getByText('Setup is complete. You can review these settings again.',{exact:true})).toBeVisible();
});
test('Saved queue views persist and moderation confirmation can be cancelled', async ({page}) => {
  await page.route(routeIs('/scans'),route=>route.fulfill({json:[{id:'994',revision:'4',file_name:'fixture.png',state:'REVIEW_REQUIRED',risk:'0.5',created_at:'2026-10-07 00:00:00'}]}));
  let views:unknown[]=[];let mutations=0;
  await page.route(routeIs('/queue-views'),route=>route.fulfill({json:views}));
  await page.route(routeIs('/queue-views/save'),async route=>{views=route.request().postDataJSON().views;await route.fulfill({json:views});});
  await page.route(routeIs('/bulk'),async route=>{mutations++;await route.fulfill({json:[]});});
  await page.getByRole('button',{name:'Moderation Queue',exact:true}).click();
  await page.getByLabel('View name',{exact:true}).fill('Review team');await page.getByRole('button',{name:'Save queue view',exact:true}).click();await expect(page.getByLabel('Saved queue view')).toContainText('Review team');
  await page.getByLabel('Select case 994',{exact:true}).check();await page.getByLabel('Required moderation reason').fill('Synthetic moderation reason');await page.getByRole('button',{name:'Approve selected'}).click();
  await page.keyboard.press('Escape');await expect(page.getByRole('dialog')).toHaveCount(0);expect(mutations).toBe(0);await expect(page.getByRole('button',{name:'Approve selected'})).toBeFocused();
});
test('Settings expose typed media controls and pass scoped accessibility checks', async ({page}) => {
  await page.getByRole('button',{name:'Settings',exact:true}).click();
  await expect(page.getByLabel('Enable PDF reconstruction and page inspection',{exact:true})).toBeVisible();
  await expect(page.getByLabel('Enable offline Content Credentials verification',{exact:true})).toBeVisible();
  const frames=page.getByLabel('Maximum sampled video frames',{exact:true});const old=await frames.inputValue();
  await frames.fill('7');await page.getByRole('button',{name:'Save settings',exact:true}).click();await expect(page.getByRole('status').first()).toContainText('saved');
  await page.reload();await page.getByRole('button',{name:'Settings',exact:true}).click();await expect(frames).toHaveValue('7');
  const results=await new AxeBuilder({page}).include('#cf-app').withTags(['wcag2a','wcag2aa','wcag21aa']).analyze();expect(results.violations).toEqual([]);
  await frames.fill(old);await page.getByRole('button',{name:'Save settings',exact:true}).click();await expect(page.getByRole('status').first()).toContainText('saved');
});
test('Real file policy simulation uses multipart and never publishes the sample', async ({page}) => {
  await page.getByRole('button',{name:'Policies',exact:true}).click();await page.getByLabel('Start from a preset').selectOption({label:'Security Only'});
  await page.getByLabel('Policy sample file',{exact:true}).setInputFiles({name:'sample.txt',mimeType:'text/plain',buffer:Buffer.from('Harmless synthetic sample without personal data.')});
  const response=page.waitForResponse(r=>routeIs('/simulation/file')(new URL(r.url())));
  await page.getByRole('button',{name:'Analyze without publishing',exact:true}).click();const value=await response;
  expect(value.status()).toBe(200);expect((await value.json()).published).toBe(false);expect(value.headers()['cache-control']).toContain('no-store');
  await expect(page.getByText('Sample was not published.',{exact:true})).toBeVisible();
});
test('Headless upload accepts a real multipart file and returns safe private status', async ({page}) => {
  const nonce=await page.evaluate(()=>(window as unknown as {CFConfig:{nonce:string}}).CFConfig.nonce);
  // A harmless PNG permits the native HTTP-upload boundary to be exercised without a provider account.
  const response=await page.request.post('/?rest_route=/content-firewall/v1/uploads',{headers:{'X-WP-Nonce':nonce},multipart:{file:{name:'headless-fixture.png',mimeType:'image/png',buffer:Buffer.from('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aWQAAAABJRU5ErkJggg==','base64')}}});
  expect(response.status(),await response.text()).toBe(200);const value=await response.json();expect(value.attachment_id).toBe(0);expect(value).not.toHaveProperty('findings');expect(value).not.toHaveProperty('private_key');
  const status=await page.request.get('/?rest_route=/content-firewall/v1/uploads/'+value.id,{headers:{'X-WP-Nonce':nonce}});expect(status.ok()).toBe(true);expect((await status.json()).id).toBe(value.id);expect(status.headers()['cache-control']).toContain('no-store');
});
