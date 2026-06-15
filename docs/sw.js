/**
 * RooterIN Service Worker v1.0
 * Handles Offline-First capabilities and asset caching for AI Diagnostic
 */

const CACHE_NAME = 'rooterin-ai-v3-gemini'; // Migration to Gemini Vision
const ASSETS_TO_CACHE = [
    'https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css'
];

self.addEventListener('install', (event) => {
    // FORCE immediate activation of new version
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

self.addEventListener('activate', (event) => {
    // Take control of all pages immediately 
    event.waitUntil(clients.claim());
    
    // Clean up old caches only
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

self.addEventListener('fetch', (event) => {
    // Strategy: Cache First, falling back to Network
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request).catch(() => {
                // If both fail and it's a diagnostic POST, it's handled by localStorage in the UI
                return null;
            });
        })
    );
});

// Background Sync for Offline Leads
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-ai-leads') {
        event.waitUntil(syncLeads());
    }
});

async function syncLeads() {
    // This would typically involve communication with the main thread or IndexedDB
    // to retrieve and POST cached leads once the connection is restored.
    console.log('Service Worker: Syncing cached leads...');
}
