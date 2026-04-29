{{-- resources/views/components/google-analytics.blade.php --}}
@if (config('services.google.analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        // Helper function to send the pageview
        function trackPageView() {
            gtag('config', '{{ config('services.google.analytics_id') }}', {
                'page_path': window.location.pathname,
                'page_location': window.location.href,
                'page_title': document.title
            });
        }

        // 1. Initial configuration on first load
        trackPageView();

        // 2. Listen for Livewire's navigation event (v3)
        document.addEventListener('livewire:navigated', () => {
            trackPageView();
        });
    </script>
@endif
