<div>
    {{-- Container Principal Escuro --}}
    <div class="w-full bg-slate-900 text-white shadow-2xl border-b border-white/10 relative z-50"
        x-data="audioPlayer()"
        x-init="initPlayer()">

        {{-- Audio Element (Hidden) --}}
        <div wire:ignore>
            <audio x-ref="audio" preload="none">
                <source src="{{ $settings->streaming_url ?? 'https://stm4.xcast.com.br:12006/stream' }}" type="audio/mpeg">
            </audio>
        </div>

        {{-- Container Flex Layout --}}
        <div class="container mx-auto px-4 py-4 md:py-2 min-h-[6rem] flex flex-col md:flex-row items-center justify-between gap-6 relative">

            {{-- 1. ESQUERDA: PLAYER CONTROLS --}}
            {{-- Adicionei 'overflow-hidden' aqui para garantir segurança no corte do texto --}}
            <div class="w-full md:w-1/3 flex justify-center md:justify-start order-2 md:order-1 overflow-hidden" wire:poll.10s>
                
                {{-- Container Interno do Player --}}
                <div class="flex items-center gap-3 w-full pr-2">
                    
                    {{-- Play Button --}}
                    {{-- shrink-0: Garante que o botão NUNCA diminua de tamanho --}}
                    <button @click="togglePlay()"
                        class="shrink-0 relative group w-12 h-12 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/30">
                        <svg x-show="!isPlaying" class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                        <svg x-show="isPlaying" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" /></svg>
                        <span x-show="isPlaying" class="absolute inset-0 rounded-full animate-ping bg-indigo-500 opacity-20"></span>
                    </button>

                    {{-- Info da Música --}}
                    {{-- flex-1 + min-w-0: O segredo para o texto ocupar o espaço restante sem quebrar o layout --}}
                    <div class="flex flex-col flex-1 min-w-0 overflow-hidden text-center md:text-left">
                        <div class="text-[10px] text-indigo-400 font-bold tracking-wider uppercase mb-0.5 flex items-center justify-center md:justify-start gap-2">
                            <span class="w-2 h-2 rounded-full flex-shrink-0 bg-red-500" :class="isPlaying ? 'animate-pulse' : ''"></span>
                            <span class="truncate">@if($currentSong) NO AR @else RÁDIO ONLINE @endif</span>
                        </div>

                        <div class="text-sm sm:text-base font-bold text-white leading-tight truncate w-full">
                            @if($currentSong)
                                <span class="text-white">{{ $currentSong->title }}</span>
                                {{-- Desktop: Artista na mesma linha --}}
                                <span class="text-slate-400 text-xs font-normal hidden sm:inline"> - {{ $currentSong->artist }}</span>
                                {{-- Mobile: Artista na linha de baixo (para economizar espaço) --}}
                                <span class="text-slate-400 text-xs font-normal block sm:hidden truncate">{{ $currentSong->artist }}</span>
                            @else
                                {{ $settings->nome ?? 'Porto União FM' }}
                            @endif
                        </div>
                    </div>

                    {{-- Visualizador (Ao lado) --}}
                    {{-- shrink-0: Garante que as barras não sejam esmagadas --}}
                    <div class="hidden lg:flex shrink-0 items-center gap-1 h-6 opacity-80" :class="isPlaying ? '' : 'opacity-30 grayscale'">
                        <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-3" :class="isPlaying ? 'animate-[music-bar_1s_ease-in-out_infinite]' : ''"></div>
                        <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-5" :class="isPlaying ? 'animate-[music-bar_1.2s_ease-in-out_infinite_0.1s]' : ''"></div>
                        <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-8" :class="isPlaying ? 'animate-[music-bar_0.8s_ease-in-out_infinite_0.2s]' : ''"></div>
                    </div>
                </div>
            </div>

            {{-- 2. CENTRO: LOGO --}}
            {{-- Absolute + Transform para centralizar na tela desktop. --}}
            <div class="order-1 md:order-2 flex-shrink-0 z-30 md:absolute md:left-1/2 md:top-1/2 md:-translate-x-1/2 md:-translate-y-1/2">
                @if($settings && $settings->logo_path)
                    {{-- Logo Grande --}}
                    <img src="{{ asset('storage/' . $settings->logo_path) }}"
                        alt="{{ $settings->nome }}"
                        class="h-32 md:h-48 lg:h-64 xl:h-72 object-contain drop-shadow-[0_10px_40px_rgba(0,0,0,0.6)] transition-all duration-300">
                @else
                    <div class="h-20 w-20 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-2xl shadow-lg border-2 border-white/20">
                        FM
                    </div>
                @endif
            </div>

            {{-- 3. DIREITA: VOLUME E USER --}}
            <div class="w-full md:w-1/3 flex flex-col sm:flex-row items-center justify-center md:justify-end gap-6 order-3 md:order-3 pt-4 md:pt-0 border-t md:border-t-0 border-white/10">
                
                {{-- Volume --}}
                <div class="flex items-center gap-3 group" wire:ignore>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                    <input type="range" min="0" max="100" x-model="volume" @input="updateVolume()"
                        class="w-24 h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-indigo-500 hover:accent-indigo-400">
                </div>

                {{-- Separador (Desktop) --}}
                <div class="hidden md:block w-px h-8 bg-white/20"></div>

                {{-- User --}}
                <div class="w-full sm:w-auto flex justify-center">
                    <livewire:header-ouvinte />
                </div>
            </div>

        </div>

        <style>
            @keyframes music-bar { 0%, 100% { height: 20%; } 50% { height: 100%; } }
        </style>

        <div wire:ignore>
            <script>
                function audioPlayer() {
                    return {
                        isPlaying: false,
                        volume: 80,
                        initPlayer() {
                            this.$refs.audio.volume = this.volume / 100;
                        },
                        togglePlay() {
                            if (this.isPlaying) { this.$refs.audio.pause(); } 
                            else { this.$refs.audio.play(); }
                            this.isPlaying = !this.isPlaying;
                        },
                        updateVolume() {
                            this.$refs.audio.volume = this.volume / 100;
                        }
                    }
                }
            </script>
        </div>
    </div>
</div>