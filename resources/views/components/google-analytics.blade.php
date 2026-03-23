<div>
    @if (config('services.google.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            // 1. Initial configuration
            gtag('config', '{{ config('services.google.analytics_id') }}');

            // 2. Listen for Livewire's navigation event
            document.addEventListener('livewire:navigated', () => {
                gtag('config', '{{ config('services.google.analytics_id') }}', {
                    'page_path': window.location.pathname,
                    'page_location': window.location.href,
                    'page_title': document.title
                });
            });
        </script>
    @endif
</div>
