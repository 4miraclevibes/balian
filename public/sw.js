const preLoad = function () {
    console.log('Service Worker: Pre-loading');
    return caches.open("offline").then(function (cache) {
        console.log('Service Worker: Caching important routes');
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    console.log('Service Worker: Installed');
    event.waitUntil(preLoad());
});

const filesToCache = [
    '/',
    '/offline.html'
];

const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

const addToCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response);
        });
    });
};

const returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
};

self.addEventListener("fetch", function (event) {
    console.log('Service Worker: Fetching', event.request.url);
    event.respondWith(checkResponse(event.request).catch(function () {
        console.log('Service Worker: Fetch failed, returning offline page instead.');
        return returnFromCache(event.request);
    }));
    if(!event.request.url.startsWith('http')){
        event.waitUntil(addToCache(event.request));
    }
});
