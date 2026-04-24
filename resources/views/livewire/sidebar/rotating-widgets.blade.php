 <div>
     @if(count($widgets) > 0)
     <div
         x-data="sidebarManager({ 
            duration: 5000, 
            totalWidgets: {{ $widgets->count() }} 
        })"
         x-show="isOpen"
         x-cloak
         x-on:sidebar-data-updated.window="syncData()"
         class="relative w-full h-[320px] perspective group">

         @foreach($widgets as $index => $widget)
         <div
             x-show="activeIndex === {{ $index }}"
             x-transition:enter="transition duration-500 ease-out"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute inset-0 bg-white border-2 border-blue-300 hover:border-pink-500 rounded-2xl shadow-lg p-4 flex flex-col">

             <a href="{{ $widget->url ?? '#' }}"
                 target="_blank"
                 rel="noopener noreferrer"
                 class="hover:text-pink-900 transition-colors uppercase tracking-tight block h-full">

                 <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-2 block">
                     {{ $widget->title }}
                 </span>

                 @if($widget->full_widget_image_path)
                 <div class="flex-1 flex items-center justify-center overflow-hidden h-[calc(100%-1.5rem)]">
                     <img src="{{ $widget->full_widget_image_path }}"
                         alt="{{ $widget->title }}"
                         class="w-full h-full object-cover rounded">
                 </div>
                 @else
                 <div class="flex-1 flex text-black items-center justify-center ad-content-area overflow-hidden h-[calc(100%-1.5rem)]">
                     {{-- This renders the RichEditor HTML --}}
                     <div class="prose prose-sm">
                         {!! $widget->content !!}
                     </div>
                 </div>
                 @endif
             </a>
         </div>
         @endforeach
     </div>
     @endif
 </div>