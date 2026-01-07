<div>
    <div class="w-full bg-slate-900 text-white shadow-xl border-b border-white/10"
        wire:poll.10s
        x-data="audioPlayer()"
        x-init="initPlayer()">

        <div wire:ignore>
            <audio x-ref="audio" preload="none">
                <source src="{{ $settings->streaming_url ?? '' }}" type="audio/mpeg">
            </audio>
        </div>

        <div class="container mx-auto px-4 h-16 flex items-center justify-between relative">

            @if($settings && $settings->logo_path)
            <img src="{{ asset('storage/' . $settings->logo_path) }}"
                alt="{{ $settings->nome }}"
                class="absolute left-4 -top-1 h-24 w-auto object-contain z-20 filter drop-shadow-[0_4px_6px_rgba(0,0,0,0.5)] pointer-events-none">
            @else
            <div class="absolute left-4 top-2 h-12 w-12 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-xl z-20">
                FM
            </div>
            @endif

            <div class="flex items-center gap-4 overflow-hidden ml-28 relative z-10">
                <button @click="togglePlay()"
                    class="shrink-0 relative group w-10 h-10 flex items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-500/30">

                    <svg x-show="!isPlaying" class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                    <svg x-show="isPlaying" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                    </svg>
                    <span x-show="isPlaying" class="absolute inset-0 rounded-full animate-ping bg-indigo-500 opacity-20"></span>
                </button>

                <div class="flex flex-col overflow-hidden mr-4">
                    <div class="text-[10px] text-indigo-400 font-bold tracking-wider uppercase mb-0.5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500" :class="isPlaying ? 'animate-pulse' : ''"></span>

                        @if($currentSong)
                        No Ar
                        @else
                        {{-- Mostra o slogan se não tiver música tocando --}}
                        {{ $settings->slogan ?? 'Rádio Online' }}
                        @endif
                    </div>

                    <div class="text-sm font-bold text-white leading-tight truncate">
                        @if($currentSong)
                        <span class="text-white">{{ $currentSong->title }}</span>
                        <span class="text-slate-400 text-xs font-normal"> - {{ $currentSong->artist }}</span>
                        @else
                        {{ $settings->nome ?? 'Minha Rádio' }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-1 h-8 opacity-80" :class="isPlaying ? '' : 'opacity-30 grayscale'">
                <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-3" :class="isPlaying ? 'animate-[music-bar_1s_ease-in-out_infinite]' : ''"></div>
                <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-5" :class="isPlaying ? 'animate-[music-bar_1.2s_ease-in-out_infinite_0.1s]' : ''"></div>
                <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-8" :class="isPlaying ? 'animate-[music-bar_0.8s_ease-in-out_infinite_0.2s]' : ''"></div>
                <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-6" :class="isPlaying ? 'animate-[music-bar_1.1s_ease-in-out_infinite_0.3s]' : ''"></div>
                <div class="w-1 bg-gradient-to-t from-indigo-500 to-cyan-400 rounded-full h-4" :class="isPlaying ? 'animate-[music-bar_0.9s_ease-in-out_infinite_0.4s]' : ''"></div>
            </div>

            <div class="flex items-center gap-3 group relative z-10" wire:ignore>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
                <input type="range" min="0" max="100" x-model="volume" @input="updateVolume()"
                    class="w-20 sm:w-24 h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-indigo-500 hover:accent-indigo-400">
            </div>

        </div>

        <style>
            @keyframes music-bar {

                0%,
                100% {
                    height: 20%;
                }

                50% {
                    height: 100%;
                }
            }
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
                            if (this.isPlaying) {
                                this.$refs.audio.pause();
                            } else {
                                this.$refs.audio.play();
                            }
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