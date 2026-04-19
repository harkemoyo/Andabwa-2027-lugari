<div class="space-y-6">
    @foreach($widgets as $widget)
        <div class="bg-gray-200 border rounded-xl p-4 shadow-sm">
            <h3 class="font-bold text-sm mb-2">{{ $widget->title }}</h3>
            <div class="text-sm text-gray-600">
                {!! $widget->content !!}
            </div>
        </div>
    @endforeach
</div>