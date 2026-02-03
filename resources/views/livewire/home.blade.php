<div>
    {{-- CSS para evitar que o Alpine "pisque" antes de carregar --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <section class="mt-1">
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
            class="relative w-full overflow-hidden rounded-xl bg-gray-900 shadow-2xl group">

            <div class="relative h-64 sm:h-80 md:h-[450px] lg:h-[550px] w-full">
                @foreach($banners as $banner)
                {{-- 
                    CORREÇÃO 1: Usamos $loop->index em vez da chave do array. 
                    Isso garante que a contagem seja sempre 0, 1, 2, 3... independente do ID do banner.
                --}}
                <div x-show="activeSlide === {{ $loop->index }}"
                    x-cloak
                    {{-- Adicionei z-index para garantir que o slide ativo fique sobre os outros durante a transição --}}
                    class="absolute inset-0 w-full h-full z-10"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-100">

                    @if($banner->link_url)
                        <a href="{{$banner->link_url}}" wire:navigate class="block w-full h-full">
                            {{-- CORREÇÃO 2: Removido wire:navigate da tag img (só deve ir no <a>) --}}
                            <img src="{{ $banner->url }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover">
                        </a>
                    @else
                        {{-- CORREÇÃO 2: Removido wire:navigate da tag img --}}
                        <img src="{{ $banner->url }}" alt="{{ $banner->titulo }}" class="w-full h-full object-cover">
                    @endif

                    {{-- Gradiente e Texto --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-5 sm:p-10 md:p-16 pointer-events-none">
                        <div class="max-w-4xl pointer-events-auto">
                            @if($banner->titulo)
                                <h2 class="text-white text-xl sm:text-3xl md:text-5xl font-bold leading-tight mb-2 md:mb-4">
                                    @if($banner->link_url)
                                        <a href="{{ $banner->link_url }}" wire:navigate class="hover:underline">{{ $banner->titulo }}</a>
                                    @else
                                        {{ $banner->titulo }}
                                    @endif
                                </h2>
                            @endif

                            @if($banner->descricao)
                                <div class="text-gray-200 text-xs sm:text-base md:text-xl mb-4 md:mb-6 prose prose-invert line-clamp-2 sm:line-clamp-3">
                                    {!! $banner->descricao !!}
                                </div>
                            @endif

                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" wire:navigate class="inline-block bg-gray-100 hover:bg-gray-300 text-gray-800 text-xs sm:text-sm md:text-base font-semibold px-2 py-1 md:px-6 md:py-3 rounded-lg transition-colors">
                                    Saiba Mais
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Setas de Navegação --}}
            <div class="hidden sm:block opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 relative">
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/30 hover:bg-black/50 text-white backdrop-blur-sm transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-black/30 hover:bg-black/50 text-white backdrop-blur-sm transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            {{-- Indicadores (Bolinhas) --}}
            <div class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-20">
                <template x-for="i in slides" :key="i">
                    <button @click="activeSlide = i-1"
                        :class="activeSlide === i-1 ? 'bg-white w-8' : 'bg-white/40 w-2 hover:bg-white/60'"
                        class="h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </section>
    
    {{-- Restante do seu código (Pedido de Música, Notícias, etc...) --}}
    <div class="max-w-7xl mx-auto px-1 py-1">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 h-full"><livewire:pedido-musica-form class="h-full" /></div>
            <div class="lg:col-span-1 h-full"><livewire:music-monitor class="h-full" /></div>
            <div class="lg:col-span-1 h-full"><livewire:top-songs class="h-full" /></div>
        </div>
    </div>

    <livewire:home-noticias />

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Nossos Parceiros</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                @foreach($anunciantes as $anunciante)
                <div class="group relative overflow-hidden rounded-lg aspect-square flex items-center justify-center border border-gray-100 hover:border-gray-200 transition-colors">
                    <img src="{{ $anunciante->url }}" alt="{{ $anunciante->nome }}" class="w-full h-full object-contain p-4 grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-110">
                    <a href="{{ $anunciante->link_url ?? '#' }}" target="_blank" class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-6 text-center">
                        <h3 class="text-white font-bold text-lg mb-2 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">{{ $anunciante->nome }}</h3>
                        @if($anunciante->descricao)
                        <div class="text-gray-200 text-sm line-clamp-3 prose prose-invert prose-sm translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75">{!! $anunciante->descricao !!}</div>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>