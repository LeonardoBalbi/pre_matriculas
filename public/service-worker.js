const APP_VERSION = 'pre-matriculas-pwa-v1';
const STATIC_CACHE = `${APP_VERSION}-static`;
const RUNTIME_CACHE = `${APP_VERSION}-runtime`;

const CORE_ASSETS = [
    '/offline.html',
    '/manifest.webmanifest',
    '/img/logo_governo_azul.png',
    '/icons/pwa-icon-192.png',
    '/icons/pwa-icon-512.png',
    '/icons/pwa-maskable-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => cache.addAll(CORE_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(
                keys
                    .filter((key) => ![STATIC_CACHE, RUNTIME_CACHE].includes(key))
                    .map((key) => caches.delete(key))
            ))
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== self.location.origin) {
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match('/offline.html'))
        );

        return;
    }

    if (shouldCacheAsset(request, url)) {
        event.respondWith(staleWhileRevalidate(request));
    }
});

function shouldCacheAsset(request, url) {
    return ['style', 'script', 'worker', 'image', 'font'].includes(request.destination)
        || url.pathname.startsWith('/build/')
        || url.pathname.startsWith('/icons/')
        || url.pathname.startsWith('/img/')
        || url.pathname.startsWith('/bt/')
        || url.pathname.endsWith('.css')
        || url.pathname.endsWith('.js')
        || url.pathname.endsWith('.png')
        || url.pathname.endsWith('.jpg')
        || url.pathname.endsWith('.jpeg')
        || url.pathname.endsWith('.webp')
        || url.pathname.endsWith('.svg')
        || url.pathname.endsWith('.ico')
        || url.pathname.endsWith('.woff2');
}

async function staleWhileRevalidate(request) {
    const cache = await caches.open(RUNTIME_CACHE);
    const cached = await cache.match(request);

    const network = fetch(request)
        .then((response) => {
            if (response && response.ok) {
                cache.put(request, response.clone());
            }

            return response;
        })
        .catch(() => cached);

    return cached || network;
}
