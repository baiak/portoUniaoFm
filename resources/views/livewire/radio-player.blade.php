<div>
    {{-- Container Principal Escuro --}}
    <div class="w-full bg-slate-900 text-white shadow-2xl border-b border-white/10"
        x-data="audioPlayer()"
        x-init="initPlayer()">

        {{-- Audio Element (Hidden) --}}
        <div wire:ignore>
            <audio x-ref="audio" preload="none">
                <source src="{{ $settings->streaming_url ?? 'https://stm4.xcast.com.br:12006/stream' }}" type="audio/mpeg">
            </audio>
        </div>

        {{-- Flex Layout: Mobile (Stack) -> Desktop (Row) --}}
        <div class="container mx-auto px-4 py-4 md:py-0 min-h-[5rem] flex flex-col md:flex-row items-center justify-between gap-6 md:gap-0 relative">

            {{-- 1. LOGO --}}
            <div class="flex-shrink-0 z-20">
                @if($settings && $settings->logo_path)
                    {{-- Logo: Maior no desktop, ajustada no mobile --}}
                    <img src="{{ asset('storage/' . $settings->logo_path) }}"
                        alt="{{ $settings->nome }}"
                        class="h-20 w-auto object-contain md:h-24 md:drop-shadow-lg">
                @else
                    <div class="h-12 w-12 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-xl">
                        FM
                    </div>
                @endif
            </div>

            {{-- 2. PLAYER CONTROLS (Centro) --}}
            {{-- Usamos wire:poll AQUI, não no root, para evitar re-renderizar o painel do usuário --}}
            <div class="flex-1 w-full md:w-auto flex flex-col items-center justify-center md:items-start md:pl-10" wire:poll.10s>
                
                <div class="flex items-center gap-4">
                    {{-- Play Button --}}
                    <button @click="togglePlay()"
                        class="shrink-0 relative group w-12 h-12 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/30">
                        <svg x-show="!isPlaying" class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                        <svg x-show="isPlaying" class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" /></svg>
                        <span x-show="isPlaying" class="absolute inset-0 rounded-full animate-ping bg-indigo-500 opacity-20"></span>
                    </button>

                    {{-- Info da Música --}}
                    <div class="flex flex-col overflow-hidden text-center md:text-left max-w-[200px] sm:max-w-md">
                        <div class="text-[10px] text-indigo-400 font-bold tracking-wider uppercase mb-0.5 flex items-center justify-center md:justify-start gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500" :class="isPlaying ? 'animate-pulse' : ''"></span>
                            @if($currentSong) NO AR @else RÁDIO ONLINE @endif
                        </div>

                        <div class="text-sm sm:text-base font-bold text-white leading-tight truncate">
                            @if($currentSong)
                                <span class="text-white">{{ $currentSong->title }}</span>
                                <span class="text-slate-400 text-xs font-normal block sm:inline"> - {{ $currentSong->artist }}</span>
                            @else
                                {{ $settings->nome ?? 'Porto União FM' }}
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Visualizador de Áudio (Barras) --}}
                <div class="hidden md:flex items-center gap-1 h-6 mt-2 ml-16 opacity-80" :class="isPlaying ? '' : 'opacity-30 grayscale'">
                    <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-3" :class="isPlaying ? 'animate-[music-bar_1s_ease-in-out_infinite]' : ''"></div>
                    <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-5" :class="isPlaying ? 'animate-[music-bar_1.2s_ease-in-out_infinite_0.1s]' : ''"></div>
                    <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-8" :class="isPlaying ? 'animate-[music-bar_0.8s_ease-in-out_infinite_0.2s]' : ''"></div>
                    <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-6" :class="isPlaying ? 'animate-[music-bar_1.1s_ease-in-out_infinite_0.3s]' : ''"></div>
                </div>
            </div>

            {{-- 3. CONTROLES DIREITA (Volume + User) --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 w-full md:w-auto justify-center md:justify-end border-t md:border-t-0 border-white/10 pt-4 md:pt-0 mt-2 md:mt-0">
                
                {{-- Volume --}}
                <div class="flex items-center gap-3 group" wire:ignore>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                    <input type="range" min="0" max="100" x-model="volume" @input="updateVolume()"
                        class="w-24 h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-indigo-500 hover:accent-indigo-400">
                </div>

                {{-- Separador Vertical (Desktop) --}}
                <div class="hidden md:block w-px h-8 bg-white/20"></div>

                {{-- Painel do Usuário (Nested Component) --}}
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