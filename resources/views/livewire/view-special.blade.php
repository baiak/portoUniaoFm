<div class="max-w-5xl mx-auto py-10 px-4 pb-40"> {{-- pb-40 para dar espaço pro player --}}

    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 mb-10 border-b border-gray-100 pb-8">
        @if($special->cover_url)
            <img src="{{ asset('storage/'.$special->cover_url) }}" class="w-48 h-48 rounded-xl shadow-lg object-cover ring-4 ring-white">
        @else
            <div class="w-48 h-48 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 10l12-3"></path></svg>
            </div>
        @endif
        
        <div class="text-center md:text-left flex-1">
             <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">{{ $special->title }}</h1>
             <p class="text-gray-500 mt-2">Clique nas faixas abaixo para ouvir</p>
        </div>
    </div>

    {{-- Lista de Músicas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        
        {{-- Loading Global --}}
        <div wire:loading wire:target="playDeezer" class="absolute top-0 left-0 right-0 z-10">
            <div class="h-1 w-full bg-purple-100 overflow-hidden">
                <div class="animate-progress w-full h-full bg-purple-600 origin-left-right"></div>
            </div>
        </div>

        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-800 text-lg">Top Músicas</h3>
        </div>

        @if(count($tracks) > 0)
            <div class="divide-y divide-gray-100">
                @foreach($tracks as $index => $track)
                    {{-- CLICK ACTION: Deezer --}}
                    <div class="group flex items-center p-4 hover:bg-purple-50 transition duration-150 ease-in-out cursor-pointer"
                         wire:click="playDeezer('{{ $track['name'] }}', '{{ $special->title }}')">
                        
                        <span class="w-8 text-center text-gray-400 font-medium group-hover:text-purple-600">
                            {{ $index + 1 }}
                        </span>

                        <div class="flex-shrink-0 ml-4 relative">
                            @if(isset($track['image'][1]['#text']))
                                <img class="h-12 w-12 rounded object-cover shadow-sm" src="{{ $track['image'][1]['#text'] }}">
                            @else
                                <div class="h-12 w-12 rounded bg-gray-200"></div>
                            @endif
                            
                            {{-- Ícone Play --}}
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded transition-all">
                                <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-purple-700">
                                {{ $track['name'] }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">{{ $special->title }}</p>
                        </div>

                        <div class="ml-4">
                            <span wire:loading wire:target="playDeezer('{{ $track['name'] }}', '{{ $special->title }}')" class="text-xs text-purple-600 font-bold">
                                Carregando...
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- PLAYER FLUTUANTE DEEZER --}}
@if($isPlaying)
        <div class="fixed bottom-0 left-0 right-0 bg-[#191922] border-t border-gray-800 shadow-[0_-4px_10px_rgba(0,0,0,0.5)] z-50 p-0 animate-slide-up">
            
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                
                {{-- 1. Informações (Só aparece no Desktop para não poluir o celular) --}}
                <div class="hidden md:flex flex-col pl-6 pr-4 w-64">
                    <span class="text-[10px] uppercase tracking-wider text-gray-500 font-bold">
                        Tocando Agora
                    </span>
                    <h4 class="text-white font-bold truncate text-sm" title="{{ $currentTrackName }}">
                        {{ $currentTrackName }}
                    </h4>
                    <span class="text-xs text-gray-400 truncate">{{ $special->title }}</span>
                </div>

                {{-- 2. O Player do Deezer (Ocupa o centro) --}}
                <div class="flex-1 relative h-[120px]"> {{-- Altura 90px fica perfeita como barra --}}
                    @if($currentEmbedUrl && $currentEmbedUrl !== 'not_found')
                        <iframe src="{{ $currentEmbedUrl }}" 
                                class="w-full h-full"
                                frameborder="0" 
                                allowtransparency="true" 
                                allow="encrypted-media; clipboard-write">
                        </iframe>
                    @elseif($currentEmbedUrl === 'not_found')
                        <div class="h-full flex items-center justify-center text-gray-400 text-sm">
                            Música não encontrada.
                        </div>
                    @else
                        {{-- Loading --}}
                        <div class="h-full flex items-center justify-center gap-3">
                            <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs text-gray-400">Carregando player...</span>
                        </div>
                    @endif
                </div>

                {{-- 3. Botão Fechar --}}
                <div class="px-4 flex items-center border-l border-gray-800 h-[90px]">
                    <button wire:click="closePlayer" 
                            class="text-gray-400 hover:text-red-400 hover:bg-white/5 rounded-full p-2 transition"
                            title="Fechar Player">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>