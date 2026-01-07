<div>
    <div wire:poll.5s class="bg-white rounded-xl shadow-lg p-6 max-w-md mx-auto">

        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">
                🎧 Porto União FM
            </h2>
            <span class="text-xs font-semibold bg-green-100 text-green-800 px-2 py-1 rounded-full animate-pulse">
                AO VIVO
            </span>
        </div>

        <div class="mb-8">
            <h3 class="text-xs uppercase tracking-wide text-gray-500 font-bold mb-3">
                Tocando Agora
            </h3>

            @if($nowPlaying)
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl p-4 text-white shadow-lg flex items-start gap-4">

                <div class="shrink-0">
                    @if(!empty($nowPlaying->cover_url))
                    <img src="{{ $nowPlaying->cover_url }}" alt="Capa" class="h-24 w-24 rounded-xl object-cover border-2 border-white/20 shadow-md">
                    @else
                    <div class="bg-white/10 h-24 w-24 rounded-xl flex items-center justify-center border-2 border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    @endif
                </div>

                <div class="overflow-hidden pt-1">
                    <h4 class="text-lg font-bold leading-tight line-clamp-2 mb-1" title="{{ $nowPlaying->title }}">
                        {{ $nowPlaying->title ?? 'Desconhecido' }}
                    </h4>
                    <p class="text-sm text-blue-200 font-medium truncate" title="{{ $nowPlaying->artist }}">
                        {{ $nowPlaying->artist ?? 'Artista Desconhecido' }}
                    </p>

                    <div class="flex gap-1 mt-3 h-3 items-end opacity-70">
                        <div class="w-1 bg-white animate-pulse h-full rounded-full"></div>
                        <div class="w-1 bg-white animate-pulse h-2/3 rounded-full delay-75"></div>
                        <div class="w-1 bg-white animate-pulse h-3/4 rounded-full delay-150"></div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-gray-400 italic p-4 text-center border border-dashed rounded-lg bg-gray-50">
                Silêncio no estúdio...
            </div>
            @endif
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
                    <div class="text-[10px] font-mono text-gray-400 whitespace-nowrap bg-gray-100 px-1.5 py-0.5 rounded">
                        {{ $track->played_at->format('H:i') }}
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-2">Sem histórico recente.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>