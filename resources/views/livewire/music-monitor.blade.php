<div>
    <div wire:poll.5s class="bg-white rounded-xl shadow-lg px-4 py-8 max-w-md mx-auto">

        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">
                🎧 Porto União FM
            </h2>
            <span class="text-xs font-semibold bg-green-100 text-green-800 px-2 py-1 rounded-full animate-pulse">
                AO VIVO
            </span>
        </div>

        <div class="mb-8">
           
<div class="mb-8">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-bold mb-3">
                Tocando Agora
            </h3>

            @if($nowPlaying)
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl p-4 text-white shadow-lg border border-gray-700 relative overflow-hidden">
                
                <div class="flex gap-4 relative z-10">
                    <div class="shrink-0">
                        @if(!empty($nowPlaying->cover_url))
                        <img src="{{ $nowPlaying->cover_url }}" class="h-24 w-24 rounded-lg object-cover shadow-black/50 shadow-lg border border-white/10">
                        @else
                        <div class="bg-gray-700 h-24 w-24 rounded-lg flex items-center justify-center border border-white/5">
                            <span class="text-3xl opacity-50">🎵</span>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1 flex flex-col justify-between min-w-0">
                        <div>
                            <h4 class="text-lg font-bold leading-tight line-clamp-2 text-white mb-1" title="{{ $nowPlaying->title }}">
                                {{ $nowPlaying->title }}
                            </h4>
                            <p class="text-sm text-blue-200 font-medium truncate">
                                {{ $nowPlaying->artist }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 mt-3">
                            
                            <button 
                                wire:click="registerVote('like')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg transition-all duration-200 border 
                                {{ $userVote === 'like' 
                                    ? 'bg-green-600 border-green-500 text-white shadow-lg scale-105 ring-2 ring-green-500/30' 
                                    : 'bg-white/5 border-white/10 text-gray-400 hover:bg-white/10 hover:text-green-400' 
                                }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                </svg>
                                <span class="text-xs font-bold hidden sm:inline">Curti</span>
                            </button>

                            <button 
                                wire:click="registerVote('dislike')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg transition-all duration-200 border
                                {{ $userVote === 'dislike' 
                                    ? 'bg-red-600 border-red-500 text-white shadow-lg scale-105 ring-2 ring-red-500/30' 
                                    : 'bg-white/5 border-white/10 text-gray-400 hover:bg-white/10 hover:text-red-400' 
                                }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-180 scale-x-[-1]" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>

                <div class="absolute -right-6 -bottom-6 opacity-5 rotate-12 pointer-events-none">
                     <svg class="h-48 w-48" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                </div>
            </div>
            @else
            <div class="text-gray-400 italic p-4 text-center border border-dashed rounded-lg bg-gray-50">
                Aguardando sinal da rádio...
            </div>
            @endif
        </div>
        </div>

        <div>
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-bold mb-3">
                Anteriores
            </h3>

            <div class="space-y-2">
                @forelse($history as $track)
                <div class="flex items-center justify-between p-2 rounded hover:bg-gray-50 transition duration-150 group">
                    <div class="flex items-center gap-3 overflow-hidden mr-2">
                        <div class="flex flex-col overflow-hidden">
                            
                            <span class="text-gray-700 text-sm font-semibold truncate group-hover:text-blue-600">
                                {{ $track->title }}
                            </span>
                            <span class="text-[10px] uppercase text-gray-400 truncate">
                                {{ $track->artist }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-2">Sem histórico recente.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>