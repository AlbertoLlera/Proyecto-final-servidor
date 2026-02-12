const CONSENT_KEY = 'devstagram-cookie-consent';
const COOKIE_MAX_AGE_YEARS = 1;

const getCookieValue = (key) => {
    return document.cookie
        .split('; ')
        .map((entry) => entry.split('='))
        .find(([cookieKey]) => cookieKey === key)?.[1] ?? '';
};

const setCookie = (key, value) => {
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + COOKIE_MAX_AGE_YEARS);
    const secure = window.location.protocol === 'https:' ? '; Secure' : '';
    document.cookie = `${key}=${value}; expires=${expires.toUTCString()}; path=/; SameSite=Lax${secure}`;
};

const toggleBanner = (banner, shouldShow) => {
    banner.classList.toggle('hidden', !shouldShow);
};

const setErrorMessage = (messageElement, message) => {
    if (!messageElement) {
        return;
    }

    if (message) {
        messageElement.textContent = message;
        messageElement.classList.remove('hidden');
    } else {
        messageElement.textContent = '';
        messageElement.classList.add('hidden');
    }
};

const registerConsent = async (endpoint, body, csrfToken) => {
    if (!endpoint) {
        throw new Error('El servidor no recibió el consentimiento.');
    }

    const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken ?? '',
        },
        body: JSON.stringify(body),
    });

    if (!response.ok) {
        const payload = await response.json().catch(() => ({}));
        throw new Error(payload?.message ?? 'No pudimos registrar tu consentimiento.');
    }

    return response.json().catch(() => ({}));
};

const ready = (callback) => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback, { once: true });
    } else {
        callback();
    }
};

export default function initCookieConsent() {
    ready(() => {
        const banner = document.getElementById('cookie-consent');
        const acceptButton = document.getElementById('cookie-accept');
        const messageElement = document.getElementById('cookie-error');
        const endpoint = banner?.dataset.cookieEndpoint ?? '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

        if (!banner) {
            return;
        }

        if (!acceptButton) {
            toggleBanner(banner, false);
            return;
        }

        if (!getCookieValue(CONSENT_KEY)) {
            toggleBanner(banner, true);
        }

        acceptButton.addEventListener('click', async () => {
            if (acceptButton.disabled) {
                return;
            }

            acceptButton.disabled = true;
            setErrorMessage(messageElement, '');

            try {
                await registerConsent(endpoint, { consent: true }, csrfToken);
                setCookie(CONSENT_KEY, 'accepted');
                toggleBanner(banner, false);
            } catch (error) {
                setErrorMessage(messageElement, error.message ?? 'No pudimos guardar tu respuesta.');
            } finally {
                acceptButton.disabled = false;
            }
        });
    });
}
