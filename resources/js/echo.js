// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT,
//     wssPort: import.meta.env.VITE_PUSHER_PORT,
//     forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
//     enabledTransports: ['ws', 'wss'],
// });


// import Echo from 'laravel-echo';

// window.Echo = new Echo({
//     broadcaster: 'reverb',
// });




import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb', // or pusher
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: false,
    disableStats: true,
});