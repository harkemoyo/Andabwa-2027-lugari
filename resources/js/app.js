/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */
// import './bootstrap';
import './echo';
document.addEventListener('track-ga-event', (event) => {
    window.trackEvent(event.detail.name, event.detail.params);
});