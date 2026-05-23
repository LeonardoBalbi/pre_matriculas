(function () {
    var deferredPrompt = null;
    var installButton = null;

    if (!('serviceWorker' in navigator)) {
        return;
    }

    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/service-worker.js', { scope: '/' })
            .catch(function () {});
    });

    window.addEventListener('beforeinstallprompt', function (event) {
        event.preventDefault();
        deferredPrompt = event;
        showInstallButton();
    });

    window.addEventListener('appinstalled', function () {
        deferredPrompt = null;
        removeInstallButton();
    });

    function showInstallButton() {
        if (installButton || window.matchMedia('(display-mode: standalone)').matches) {
            return;
        }

        installButton = document.createElement('button');
        installButton.type = 'button';
        installButton.textContent = 'Instalar app';
        installButton.setAttribute('aria-label', 'Instalar aplicativo');
        installButton.style.position = 'fixed';
        installButton.style.right = '16px';
        installButton.style.bottom = '16px';
        installButton.style.zIndex = '2147483647';
        installButton.style.minHeight = '44px';
        installButton.style.padding = '10px 16px';
        installButton.style.border = '0';
        installButton.style.borderRadius = '8px';
        installButton.style.background = '#145ab8';
        installButton.style.color = '#ffffff';
        installButton.style.boxShadow = '0 12px 28px rgba(20, 90, 184, .25)';
        installButton.style.font = '600 14px system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif';
        installButton.style.cursor = 'pointer';

        installButton.addEventListener('click', function () {
            if (!deferredPrompt) {
                return;
            }

            deferredPrompt.prompt();
            deferredPrompt.userChoice.finally(function () {
                deferredPrompt = null;
                removeInstallButton();
            });
        });

        document.body.appendChild(installButton);
    }

    function removeInstallButton() {
        if (installButton) {
            installButton.remove();
            installButton = null;
        }
    }
})();
