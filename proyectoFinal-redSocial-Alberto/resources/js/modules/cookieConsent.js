const CONSENT_KEY = 'devstagram-cookie-consent';
const COOKIE_MAX_AGE_YEARS = 1;

const getCookie = (key) => {
    return document.cookie.split('; ').find((row) => row.indexOf(`${key}=`) === 0) || '';
};

const setCookie = (key, value) => {
    const expires = new Date();
    expires.setFullYear(expires.getFullYear() + COOKIE_MAX_AGE_YEARS);
    document.cookie = `${key}=${value}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
};

const showBanner = (banner) => {
    banner.classList.remove('hidden');
};

const hideBanner = (banner) => {
    banner.classList.add('hidden');
};

export default function initCookieConsent() {
    const banner = document.getElementById('cookie-consent');
    const acceptButton = document.getElementById('cookie-accept');

    if (!banner || !acceptButton) {
        return;
    }

    if (!getCookie(CONSENT_KEY)) {
        showBanner(banner);
    }

    acceptButton.addEventListener('click', () => {
        setCookie(CONSENT_KEY, 'accepted');
        hideBanner(banner);
    });
}
