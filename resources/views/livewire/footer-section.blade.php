<footer data-aos="fade-up" data-aos-duration="1000"
    class=" bg-gray-800  dark:bg-gray-900 text-white dark:text-gray-100 border-t border-gray-200 dark:border-gray-700 shadow-sm shadow-emerald-100/50 dark:shadow-emerald-900/20">

    {{-- Main Grid --}}
    <div class="max-w-[1400px] xl:max-w-[1400px] mx-auto pb-8 px-6 sm:px-10 lg:px-10 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 md:gap-20">
        {{-- Footer Info --}}
        <div class="space-y-2 justify-start text-left ">
            @if ($footerInfo)
            <div class="flex -mt-6 justify-center md:justify-self-start">
                <livewire:navigation-logo-header-component />
            </div>

            <p class="leading-relaxed font-extrabold  text-xl">
                {{ $footerInfo->description }}
            </p>

            <div class="space-y-2  text-sm">
                @if ($footerInfo->address)
                <p class="">
                    <a href="#" class="hover:undeline "><span class="font-extrabold text-md ">Address:</span>
                    {{ $footerInfo->address }}</a>
                </p>
                @endif

                @if ($footerInfo->phone)
                <p class="">
                   <a href="tel:+25470000000" class="hover:undeline "><span class=" font-extrabold text-md">Phone:</span>
                    {{ $footerInfo->phone }}</a> 
                </p>
                @endif

                @if ($footerInfo->email)
                <p class="">
                   <a href="mailto:info@andabwafondation.com" class="hover:undeline "> <span class="font-extrabold text-md ">Email:</span>
                    {{ $footerInfo->email }}</a>
                </p>
                @endif
            </div>

            @else
            <p class="text-gray-500 dark:text-gray-400">Footer info not available.</p>
            @endif
        </div>

        {{-- Call To Action --}}
        <div
            class="bg-black justfy-center md:-mr-8 text-white rounded-2xl p-4 flex flex-col items-center text-center shadow-inner shadow-emerald-900/30 hover:shadow-emerald-600/40 transition-all duration-300">

            @if ($footerCta)
            <h3 class="text-2xl font-bold py-2 tracking-tight">
                {{ $footerCta->title }}
            </h3>

            <p class="mb-6  max-w-sm leading-relaxed">
                {{ $footerCta->subtitle }}
            </p>

            @if ($footerCta->button_text && $footerCta->button_link)
            <button @click="$dispatch('register-modal')"
                class="bg-white dark:bg-gray-900 text-black dark:text-white px-7 py-3 rounded-lg font-medium
                              hover:shadow-green-50 shadow-lg transition-all duration-300
                              focus:outline-none focus:ring-2 focus:ring-emerald-100">
                {{ $footerCta->button_text }}
            </button>
            @endif

            @else
            <p class="text-gray-400 dark:text-gray-200">CTA not configured.</p>
            @endif
        </div>

        {{-- Social Links --}}
        <div class="space-y-2  justify-start sm:justify-center md:justify-end text-left md:text-center sm:text-left ">
                <h2 class="text-xl font-extrabold justify-center text-center items-center  tracking-tight ">Follow Us:</h2>
                <livewire:social-links-component />
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class=" text-center py-2  text-sm text-gray-600 dark:text-gray-400 -mt-8 pb-2">
        <p>&copy; {{ date('Y') }} {{ $footerInfo->company_name ?? 'Your Company' }} — All rights reserved.</p>
    </div>
</footer>