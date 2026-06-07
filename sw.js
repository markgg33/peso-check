const CACHE_NAME = "peso-check-v1";

const urlsToCache = [
  "./",
  "./index.php",
  "./dashboard.php",
  "./expenses.php",
  "./statistics.php",
  "./profile.php",
  "./css/main.css",
  "./css/theme.css",
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache)),
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    }),
  );
});
