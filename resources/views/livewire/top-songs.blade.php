<div>
<div wire:poll.10s class="bg-white rounded-xl shadow-lg px-4 py-8 max-w-md mx-auto">
    
    <div class="flex items-center justify-between mb-6 border-b pb-2 border-gray-100">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            🏆 Top da Galera
        </h2>
        <span class="text-xs font-semibold text-gray-400 uppercase">
            Mais votadas
        </span>
    </div>

    <div class="space-y-4">
        @forelse($songs as $index => $song)
            
            @if($loop->first)
                <div class="relative bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl p-4 text-white shadow-lg mb-6 transform hover:scale-[1.02] transition-transform duration-300">
                    
                    <div class="absolute -top-3 -right-3 bg-white text-yellow-500 rounded-full h-8 w-8 flex items-center justify-center font-bold shadow-sm border-2 border-yellow-100 z-10">
                        1º
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-3 group">
                            @if($song->cover_url)
                                <img src="{{ $song->cover_url }}" class="h-32 w-32 rounded-lg shadow-md border-4 border-white/30 object-cover">
                            @else
                                <div class="h-32 w-32 rounded-lg bg-white/20 flex items-center justify-center border-4 border-white/30">
                                    <span class="text-4xl">🎵</span>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-white/20 rounded-lg blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </div>

                        <h3 class="text-xl font-bold leading-tight drop-shadow-sm">
                            {{ $song->title }}
                        </h3>
                        <p class="text-sm text-yellow-50 font-medium opacity-90 mb-2">
                            {{ $song->artist }}
                        </p>

                        <div class="bg-white/20 px-4 py-1 rounded-full text-xs font-bold flex items-center gap-1 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                            {{ $song->likes }} votos
                        </div>
                    </div>
                </div>

            @else
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                    
                    <div class="text-lg font-bold text-gray-300 w-6 text-center">
                        {{ $loop->iteration }}º
                    </div>

                    <div class="shrink-0">
                        @if($song->cover_url)
                            <img src="{{ $song->cover_url }}" class="h-10 w-10 rounded-md object-cover shadow-sm">
                        @else
                            <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center text-xs">
                                🎵
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-700 truncate">
                            {{ $song->title }}
                        </h4>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $song->artist }}
                        </p>
                    </div>

                    <div class="text-xs font-semibold text-gray-400 flex items-center gap-1 bg-gray-100 px-2 py-1 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        {{ $song->likes }}
                    </div>
                </div>
            @endif

        @empty
            <div class="text-center py-8 text-gray-400">
                <p class="text-sm">Ainda sem votos essa semana.</p>
                <p class="text-xs mt-1">Seja o primeiro a votar!</p>
            </div>
        @endforelse
    </div>
</div>
</div>
