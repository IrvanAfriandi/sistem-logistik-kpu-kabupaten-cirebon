import { createRequire } from 'node:module';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import os from 'node:os';
import fs from 'node:fs/promises';

const projectRoot = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const moduleRoot = process.env.SCREENSHOT_NODE_MODULES
    ?? path.join(projectRoot, 'node_modules');
const moduleRequire = createRequire(path.join(moduleRoot, 'screenshot-loader.cjs'));
const { chromium } = moduleRequire('playwright');
const sharp = moduleRequire('sharp');
const baseUrl = (process.env.SCREENSHOT_BASE_URL ?? 'http://127.0.0.1:8000').replace(/\/$/, '');
const screenshotDirectory = path.join(projectRoot, 'screenshots');
const publicImagesDirectory = path.join(projectRoot, 'public', 'images');
const maxScreenshots = 12;
const viewport = { width: 1920, height: 870 };
const password = process.env.SCREENSHOT_PASSWORD ?? 'ScreenshotPass123!';
const roles = {
    Admin: {
        email: process.env.SCREENSHOT_ADMIN_EMAIL ?? 'admin@example.test',
        landingPath: '/admin',
    },
    PPK: {
        email: process.env.SCREENSHOT_PPK_EMAIL ?? 'ppk@example.test',
        landingPath: '/ppk',
    },
};

const captured = [];
const capturedFeatures = new Set();
const failures = [];
let screenshotNumber = 0;
let uploadedImagePath = null;
let previousImageNames = new Set();

async function delay(milliseconds) {
    await new Promise((resolve) => setTimeout(resolve, milliseconds));
}

async function waitUntilReady(page) {
    await page.evaluate(async () => {
        if (document.fonts?.ready) {
            await document.fonts.ready;
        }
        await Promise.all(Array.from(document.images, (image) => {
            if (image.complete) {
                return Promise.resolve();
            }
            return new Promise((resolve) => {
                image.addEventListener('load', resolve, { once: true });
                image.addEventListener('error', resolve, { once: true });
            });
        }));
        document.querySelectorAll('footer').forEach((footer) => footer.remove());
    });
    await page.addStyleTag({
        content: `
            #debugbar, .phpdebugbar, #phpdebugbar, .cookie-banner,
            [data-cookie-consent], .cookie-consent {
                display: none !important;
            }
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                caret-color: transparent !important;
            }
        `,
    });
    await delay(1500);
}

async function navigate(page, route) {
    const response = await page.goto(`${baseUrl}${route}`, {
        waitUntil: 'networkidle',
        timeout: 60000,
    });
    if (!response || response.status() >= 400) {
        throw new Error(`HTTP ${response?.status() ?? 'no response'} for ${route}`);
    }
    await waitUntilReady(page);

    if (new URL(page.url()).pathname !== route && route !== '/') {
        throw new Error(`Redirected from ${route} to ${new URL(page.url()).pathname}`);
    }

    const bodyText = await page.locator('body').innerText();
    if (/\b(?:500|419)\b|404 Not Found|Page Expired|Server Error|Internal Server Error/i.test(bodyText)) {
        throw new Error(`Error page detected for ${route}`);
    }
}

async function captureCurrentPage(page, slug, caption, role, feature) {
    if (screenshotNumber >= maxScreenshots) {
        throw new Error(`Screenshot limit (${maxScreenshots}) reached before ${slug}.`);
    }

    const dimensions = await page.evaluate(() => ({
        height: Math.max(document.documentElement.scrollHeight, document.body.scrollHeight),
        viewportHeight: window.innerHeight,
    }));
    const maximumScroll = Math.max(0, dimensions.height - dimensions.viewportHeight);
    const positions = [0];
    for (let position = dimensions.viewportHeight; position < maximumScroll; position += dimensions.viewportHeight) {
        positions.push(position);
    }
    if (maximumScroll > 0 && positions.at(-1) !== maximumScroll) {
        positions.push(maximumScroll);
    }

    for (let index = 0; index < positions.length; index++) {
        if (screenshotNumber >= maxScreenshots) {
            throw new Error(`Screenshot limit (${maxScreenshots}) reached while capturing ${slug}.`);
        }
        await page.evaluate((position) => window.scrollTo(0, position), positions[index]);
        await delay(250);
        screenshotNumber++;
        const suffix = index === 0 ? '' : `-lanjutan${index > 1 ? `-${index + 1}` : ''}`;
        const file = `${String(screenshotNumber).padStart(2, '0')}-${slug}${suffix}.webp`;
        const pngPath = path.join(pngDirectory, `${String(screenshotNumber).padStart(2, '0')}-${slug}${suffix}.png`);
        const webpPath = path.join(screenshotDirectory, file);

        await page.screenshot({ path: pngPath, type: 'png', fullPage: false });
        await sharp(pngPath).webp({ quality: 85 }).toFile(webpPath);
        const metadata = await sharp(webpPath).metadata();
        if (metadata.width !== viewport.width || metadata.height !== viewport.height) {
            throw new Error(`Unexpected screenshot dimensions for ${file}: ${metadata.width}x${metadata.height}`);
        }

        captured.push({
            file,
            caption: index === 0 ? caption : `${caption} (bagian lanjutan).`,
            role,
        });
        capturedFeatures.add(feature);
    }
    await page.evaluate(() => window.scrollTo(0, 0));
}

async function captureRoute(page, route, slug, caption, role, feature, prepare) {
    try {
        await navigate(page, route);
        if (prepare) {
            await prepare(page);
            await waitUntilReady(page);
        }
        await captureCurrentPage(page, slug, caption, role, feature);
    } catch (error) {
        failures.push(`${role} ${route}: ${error.message}`);
    }
}

async function loginAndRestoreState(browser, role, statePath) {
    const credentials = roles[role];
    const loginContext = await browser.newContext({ viewport, deviceScaleFactor: 1 });
    const loginPage = await loginContext.newPage();
    await navigate(loginPage, '/login');
    await loginPage.locator('input[name="email"]').fill(credentials.email);
    await loginPage.locator('input[name="password"]').fill(password);
    await Promise.all([
        loginPage.waitForURL((url) => url.pathname === credentials.landingPath, { timeout: 30000 }),
        loginPage.locator('button[type="submit"]').click(),
    ]);
    await waitUntilReady(loginPage);
    await loginContext.storageState({ path: statePath });
    await loginContext.close();
    return browser.newContext({
        viewport,
        deviceScaleFactor: 1,
        storageState: statePath,
    });
}

async function screenshotLogin(browser) {
    const context = await browser.newContext({ viewport, deviceScaleFactor: 1 });
    const page = await context.newPage();
    await navigate(page, '/login');
    await captureCurrentPage(page, 'login', 'Form masuk untuk Admin dan PPK.', 'Publik', 'login');
    await context.close();
}

async function verifyDummyDataset(browser) {
    const context = await browser.newContext({ viewport, deviceScaleFactor: 1 });
    const page = await context.newPage();
    await navigate(page, '/box');
    const rows = await page.locator('tbody tr').allInnerTexts();
    await context.close();
    if (rows.length < 8 || rows.some((row) => !row.includes('BOX-TEST-'))) {
        throw new Error('Refusing to capture: /box does not contain only the expected synthetic test rows.');
    }
}

function makeSummary() {
    const features = [
        ['dashboard', 'Dashboard administrasi sebagai pintu masuk modul logistik.'],
        ['boxes', 'Pencatatan box surat suara, jenis, dan statusnya.'],
        ['sorlip', 'Pemantauan kegiatan sortir dan lipat surat suara.'],
        ['inventory', 'Pengelolaan stok perlengkapan pemilu.'],
        ['packing', 'Pemantauan kebutuhan set dan packing per kecamatan.'],
        ['accounts', 'Manajemen akun PPK dan pengisian profil dengan foto.'],
        ['ppk', 'Halaman kerja PPK untuk memantau progres sortir-lipat.'],
    ].filter(([key]) => capturedFeatures.has(key)).map(([, description]) => description);

    return {
        slug: 'logistik',
        title: 'Sistem Informasi Logistik KPU Kabupaten Cirebon',
        category: 'Logistik Pemilu',
        shortDescription: 'Pengelolaan logistik pemilu, dari surat suara dan perlengkapan hingga packing dan distribusi.',
        tags: ['Laravel', 'MySQL', 'Bootstrap 5'],
        about: 'Aplikasi ini mendukung pengelolaan logistik pemilu untuk operator Admin dan PPK, termasuk pencatatan surat suara, perlengkapan, serta proses sortir, packing, dan distribusi. Proyek dibangun dengan Laravel 10 dan Blade, dengan antarmuka berbasis Mazer dan Bootstrap.',
        features: features.slice(0, 6),
        technologies: [
            'Laravel 10',
            'PHP 8.1+',
            'MySQL (default konfigurasi)',
            'SQLite (database sementara screenshot)',
            'Blade',
            'Bootstrap 5 (antarmuka Mazer)',
            'JavaScript',
            'Vite',
            'Laravel Sanctum',
            'barryvdh/laravel-dompdf',
            'Guzzle',
        ],
        liveUrl: null,
        repoUrl: 'https://github.com/IrvanAfriandi/sistem-logistik-kpu-kabupaten-cirebon',
        screenshots: captured.map(({ file, caption }) => ({ file, caption })),
    };
}

let pngDirectory;
let stateDirectory;
let browser;

try {
    await fs.mkdir(screenshotDirectory, { recursive: true });
    const oldFiles = await fs.readdir(screenshotDirectory);
    pngDirectory = await fs.mkdtemp(path.join(os.tmpdir(), 'logistik-screenshot-png-'));
    stateDirectory = await fs.mkdtemp(path.join(os.tmpdir(), 'logistik-screenshot-state-'));
    browser = await chromium.launch({ headless: true });
    await verifyDummyDataset(browser);

    for (const oldFile of oldFiles) {
        if (/^\d{2}-[a-z0-9-]+\.webp$/i.test(oldFile)) {
            await fs.unlink(path.join(screenshotDirectory, oldFile));
        }
    }

    const adminStatePath = path.join(stateDirectory, 'admin-state.json');
    const adminContext = await loginAndRestoreState(browser, 'Admin', adminStatePath);
    const adminPage = await adminContext.newPage();
    await captureRoute(
        adminPage,
        '/admin',
        'dashboard',
        'Dashboard utama Admin untuk navigasi pengelolaan logistik.',
        'Admin',
        'dashboard',
        async (page) => {
            await page.locator('#main .page-content > section.row').first().evaluate((section) => {
                const privateColumn = section.querySelector(':scope > .col-12.col-lg-3');
                const dashboardColumn = section.querySelector(':scope > .col-12.col-lg-9');
                privateColumn?.remove();
                dashboardColumn?.classList.remove('col-lg-9');
                dashboardColumn?.classList.add('col-lg-12');
            });
        },
    );
    await screenshotLogin(browser);
    await captureRoute(
        adminPage,
        '/box',
        'daftar-box-surat-suara',
        'Daftar box surat suara dengan data uji dan pencarian aktif.',
        'Admin',
        'boxes',
        async (page) => {
            const search = page.locator(
                'input[type="search"], input[placeholder*="Search"], input[placeholder*="search"]',
            ).first();
            await search.waitFor({ state: 'visible', timeout: 5000 });
            await search.fill('BOX-TEST');
            await delay(500);
            if (await search.inputValue() !== 'BOX-TEST') {
                throw new Error('The box-list search field did not retain the synthetic filter.');
            }
            const visibleRows = await page.locator('tbody tr:visible').allInnerTexts();
            if (!visibleRows.length || visibleRows.some((row) => !row.includes('BOX-TEST'))) {
                throw new Error('The box-list search did not filter to the expected synthetic records.');
            }
        },
    );
    await adminContext.close();

    const ppkContext = await loginAndRestoreState(
        browser,
        'PPK',
        path.join(stateDirectory, 'ppk-state.json'),
    );
    const ppkPage = await ppkContext.newPage();
    await captureRoute(
        ppkPage,
        '/sorlip_pengawas',
        'pemantauan-sorlip-ppk',
        'Halaman PPK untuk memantau progres sortir-lipat petugas.',
        'PPK',
        'ppk',
    );
    await ppkContext.close();

    if (screenshotNumber < maxScreenshots) {
        const uploadContext = await browser.newContext({
            viewport,
            deviceScaleFactor: 1,
            storageState: adminStatePath,
        });
        try {
            const uploadPage = await uploadContext.newPage();
            await navigate(uploadPage, '/users_ppk/2/edit');
            previousImageNames = new Set(await fs.readdir(publicImagesDirectory).catch(() => []));
            const uploadFile = path.join(pngDirectory, 'foto-profil-demo.png');
            await sharp({
                create: {
                    width: 256,
                    height: 256,
                    channels: 3,
                    background: { r: 34, g: 90, b: 145 },
                },
            }).png().toFile(uploadFile);
            await uploadPage.locator('input[type="file"][name="foto"]').setInputFiles(uploadFile);
            await waitUntilReady(uploadPage);
            await captureCurrentPage(
                uploadPage,
                'pilih-foto-profil',
                'Form akun PPK berisi data contoh dan foto dummy yang telah dipilih.',
                'Admin',
                'accounts',
            );

            if (screenshotNumber < maxScreenshots) {
                await Promise.all([
                    uploadPage.waitForURL((url) => url.pathname === '/users_ppk', { timeout: 30000 }),
                    uploadPage.locator('form button[type="submit"]').last().click(),
                ]);
                await waitUntilReady(uploadPage);
                await captureCurrentPage(
                    uploadPage,
                    'unggah-foto-berhasil',
                    'Konfirmasi setelah foto dummy akun PPK berhasil diunggah.',
                    'Admin',
                    'accounts',
                );
                const profileEdit = await uploadContext.newPage();
                await navigate(profileEdit, '/users_ppk/2/edit');
                const profileImage = await profileEdit.locator('#profile-photo').getAttribute('src');
                if (profileImage) {
                    const imageName = path.basename(new URL(profileImage, baseUrl).pathname);
                    const candidate = path.join(publicImagesDirectory, imageName);
                    if (/^\d+\.png$/i.test(imageName) && !previousImageNames.has(imageName)) {
                        uploadedImagePath = candidate;
                    }
                }
            }
        } catch (error) {
            failures.push(`Admin profile upload: ${error.message}`);
        } finally {
            await uploadContext.close();
        }
    }

    const summary = makeSummary();
    await fs.writeFile(
        path.join(screenshotDirectory, 'project-summary.json'),
        `${JSON.stringify(summary, null, 2)}\n`,
        'utf8',
    );

    console.log(`Saved ${captured.length} WebP screenshot(s) to ${screenshotDirectory}.`);
    for (const item of captured) {
        console.log(`${item.file} [${item.role}] ${item.caption}`);
    }
    for (const failure of failures) {
        console.error(`Skipped: ${failure}`);
    }
} finally {
    if (browser) {
        await browser.close();
    }
    if (uploadedImagePath && !previousImageNames.has(path.basename(uploadedImagePath))) {
        await fs.unlink(uploadedImagePath).catch((error) => {
            console.error(`Could not remove the temporary uploaded image ${uploadedImagePath}: ${error.message}`);
        });
    }
    if (pngDirectory) {
        await fs.rm(pngDirectory, { recursive: true, force: true });
    }
    if (stateDirectory) {
        await fs.rm(stateDirectory, { recursive: true, force: true });
    }
}
