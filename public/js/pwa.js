if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/service-worker.js')
      .then(registration => {
        console.log('Service Worker berhasil didaftarkan:', registration.scope);
      })
      .catch(error => {
        console.log('Pendaftaran Service Worker gagal:', error);
      });
  });
}
