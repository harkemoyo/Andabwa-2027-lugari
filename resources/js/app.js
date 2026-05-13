/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
// import './bootstrap';
import { createApp } from 'vue';

document.addEventListener('livewire:navigated', () => {
    const streamContainer = document.getElementById('vue-stream-app');

    if (streamContainer && !streamContainer.__vue_app__) {
        const app = createApp(LivestreamRoom, {
            token: streamContainer.dataset.token,
            url: streamContainer.dataset.url,
            isHost: streamContainer.dataset.host === 'true',
            title: streamContainer.dataset.title,
            description: streamContainer.dataset.description,
        });

        app.mount(streamContainer);
    }
});

document.addEventListener('track-ga-event', (event) => {
    window.trackEvent(event.detail.name, event.detail.params);
});