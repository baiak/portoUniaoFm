<div>
    @if($settings)
    <h1 class="text-3xl font-bold">{{ $settings->nome }}</h1>
    <p>{{ $settings->slogan }}</p>
    @endif

    <!-- CARROSSEL DE BANNERS -->
    <section class="mt-10">
        <div x-data="{ 
            activeSlide: 0, 
            slides: {{ $banners->count() }},
            touchStartX: 0,
            touchEndX: 0,
            next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
            prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
            handleSwipe() {
                const threshold = 50;
                if (this.touchStartX - this.touchEndX > threshold) {
                    this.next();
                } else if (this.touchEndX - this.touchStartX > threshold) {
                    this.prev();
                }
            }
        }"
            x-init="setInterval(() => next(), 5000)"
            @touchstart="touchStartX = $event.touches[0].clientX"
            @touchend="touchEndX = $event.changedTouches[0].clientX; handleSwipe()"
            class="relative w-full overflow-hidden rounded-xl bg-gray-900 shadow-2xl">

            <div class="relative h-64 sm:h-80 md:h-[450px] lg:h-[550px] w-full">
                @foreach($banners as $index => $banner)
                <div x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    class="absolute inset-0">

                    @if($banner->link_url)
                    <a href="{{$banner->link_url}}">
                        <img src="{{ $banner->url }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover">
                    </a>
                    @else
                    <img src="{{ $banner->url }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover">
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-5 sm:p-10 md:p-16 pointer-events-none">
                        <div class="max-w-4xl pointer-events-auto">
                            @if($banner->titulo)
                            @if($banner->link_url)
                            <h2 class="text-white text-xl sm:text-3xl md:text-5xl font-bold leading-tight mb-2 md:mb-4">
                                <a href="{{ $banner->link_url }}" class="hover:underline">{{ $banner->titulo }}</a>
                            </h2>
                            @else
                            <h2 class="text-white text-xl sm:text-3xl md:text-5xl font-bold leading-tight mb-2 md:mb-4">
                                {{ $banner->titulo }}
                            </h2>
                            @endif
                            @endif

                            @if($banner->descricao)
                            <div class="text-gray-200 text-xs sm:text-base md:text-xl mb-4 md:mb-6 prose prose-invert line-clamp-2 sm:line-clamp-3">
                                {!! $banner->descricao !!}
                            </div>
                            @endif

                            @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" class="inline-block bg-gray-100 hover:bg-gray-300 text-gray-800 text-xs sm:text-sm md:text-base font-semibold px-2 py-1 md:px-6 md:py-3 rounded-lg transition-colors">
                                Saiba Mais
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="hidden sm:block">
                <button @click="prev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/20 hover:bg-black/40 text-white transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="next()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/20 hover:bg-black/40 text-white transition">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div class="absolute bottom-3 md:bottom-6 left-1/2 -translate-x-1/2 flex space-x-1 md:space-x-2">
                <template x-for="i in slides" :key="i">
                    <button @click="activeSlide = i-1"
                        :class="activeSlide === i-1 ? 'bg-white w-4 md:w-8' : 'bg-white/40 w-1.5 md:w-2'"
                        class="h-1.5 md:h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </section>
    <!-- CARROSSEL DE BANNERS -->

    <!-- ANUNCIANTES -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Nossos Parceiros</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                @foreach($anunciantes as $anunciante)
                <div class="group relative overflow-hidden rounded-lg aspect-square flex items-center justify-center">
                    <img src="{{ $anunciante->url }}"
                        alt="{{ $anunciante->nome }}"
                        class="w-full h-full object-contain p-4 grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-125">

                    <a href="{{ $anunciante->link_url ?? '#' }}"
                        target="_blank"
                        class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-6 text-center">

                        <h3 class="text-white font-bold text-lg md:text-xl mb-2 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            {{ $anunciante->nome }}
                        </h3>
                        @if($anunciante->descricao)
                        <div class="text-gray-200 text-xs md:text-sm line-clamp-3 prose prose-invert prose-sm translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">
                            {!! $anunciante->descricao !!}
                        </div>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- ANUNCIANTES -->
</div>