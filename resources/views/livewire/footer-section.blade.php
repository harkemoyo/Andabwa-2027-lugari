<footer data-aos="fade-up" data-aos-duration="1000"
    class="relative bg-slate-950 text-slate-200 border-t border-white/5 overflow-hidden">
        
    {{-- Subtle Background Glow - Ties into Navbar Palette --}}
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-purple-600/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-96 h-96 bg-red-600/10 blur-[120px] rounded-full"></div>

    <div class="relative max-w-[1400px] mx-auto px-6 sm:px-10 lg:px-10 py-6">
        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6  items-start">            
            {{-- Column 1: Info (Spans 4) --}}
            <div class="lg:col-span-4 space-y-6">
                @if ($footerInfo)
                    <div class="flex flex-col items-start gap-4">                        
                        <p class="text-slate-400 leading-relaxed text-sm lg:text-base lg:text-md font-extrabold max-w-sm">
                            {{ $footerInfo->description }}
                        </p>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-white/5">
                        @if ($footerInfo->address)
                        <div class="group flex items-start gap-3">
                            <span class="text-purple-400 font-bold text-sm uppercase tracking-wider">Office</span>
                            <a href="#" class="text-slate-300 hover:text-white transition-colors text-sm leading-tight italic">
                                {{ $footerInfo->address }}
                            </a>
                        </div>
                        @endif

                        <div class="flex flex-wrap gap-x-8 gap-y-4">
                            @if ($footerInfo->phone)
                            <a href="tel:{{ $footerInfo->phone }}" class="group flex flex-col gap-1">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 group-hover:text-pink-500 transition-colors">Phone Support</span>
                                <span class="text-sm font-semibold text-slate-200 group-hover:text-white">{{ $footerInfo->phone }}</span>
                            </a>
                            @endif

                            @if ($footerInfo->email)
                            <a href="mailto:{{ $footerInfo->email }}" class="group flex flex-col gap-1">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 group-hover:text-red-500 transition-colors">Email Us</span>
                                <span class="text-sm font-semibold text-slate-200 group-hover:text-white">{{ $footerInfo->email }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Column 2: CTA (Spans 5) --}}
            <div class="lg:col-span-5">
                <div class="relative group overflow-hidden bg-gradient-to-br from-slate-900 to-slate-950 border border-white/10 rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:border-purple-500/30">
                    {{-- Decorative Internal Glow --}}
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/10 blur-3xl rounded-full group-hover:bg-purple-500/20 transition-all"></div>
                    
                    @if ($footerCta)
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <h3 class="text-2xl font-black text-white mb-3 tracking-tight italic">
                                {{ $footerCta->title }}
                            </h3>
                            <p class="text-slate-400 text-sm mb-8 leading-relaxed max-w-xs">
                                {{ $footerCta->subtitle }}
                            </p>

                            @if ($footerCta->button_text && $footerCta->button_link)
                            <button @click="$dispatch('register-modal')"
                                class="relative w-full sm:w-auto px-10 py-4 bg-white text-slate-950 rounded-xl font-black text-xs uppercase tracking-widest
                                              hover:bg-gradient-to-r hover:from-purple-500 hover:to-red-500 hover:text-white
                                              transform hover:-translate-y-1 transition-all duration-300 shadow-[0_10px_40px_-10px_rgba(255,255,255,0.2)]">
                                {{ $footerCta->button_text }}
                            </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Column 3: Socials (Spans 3) --}}
            <div class="lg:col-span-3 flex flex-col items-start lg:items-end justify-between h-full py-4">
                <div class="space-y-4 w-full lg:text-right">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-500">Connect with us</h2>
                    <div class="flex lg:justify-end">
                        <livewire:social-links-component />
                    </div>
                </div>
                
                <div class="hidden lg:block pt-10">
                    <p class="text-[10px] text-slate-600 uppercase tracking-widest font-medium">
                        Standard of Excellence &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom Copyright Section --}}
        <div class="py-8 mt-4 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                {{ $footerInfo->company_name ?? 'Your Company' }} — All rights reserved.
            </p>
            <div class="flex gap-6 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <a href="#" class="hover:text-white transition-colors">Terms</a>
            </div>
        </div>
    </div>
</footer>