import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb', // or pusher
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: false,
    disableStats: true,
});