<div class="bg-slate-100 min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6 bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Arquivo Musical</h1>
                <p class="text-indigo-600 font-medium italic">Explorando o que tocou na Porto União FM</p>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Data da Programação</label>
                <input type="date" wire:model.live="date" class="border-slate-200 rounded-2xl shadow-sm focus:ring-indigo-500 text-slate-700 font-bold px-4 py-2">
            </div>
        </div>

        {{-- GRID DE DESTAQUES --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-12">
            
            {{-- 1. BOX: A MAIS CURTIDA (Com Capa) --}}
            <div class="lg:col-span-4 bg-white rounded-[2rem] p-6 shadow-xl shadow-indigo-100 border border-slate-100 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                
                <span class="absolute top-4 left-4 bg-indigo-600 text-white text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest z-10 shadow-lg">
                    A Favorita do Dia
                </span>

                @if($mostLiked)
                    {{-- Imagem da Capa (Destaque Central) --}}
                    <div class="relative w-48 h-48 mb-6 mt-4 group-hover:scale-105 transition duration-500">
                        @if($mostLiked->cover_url)
                            <img src="{{ $mostLiked->cover_url }}" class="w-full h-full object-cover rounded-2xl shadow-2xl shadow-indigo-200 rotate-3 group-hover:rotate-0 transition duration-500">
                        @else
                            <div class="w-full h-full bg-slate-100 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-200">
                                <span class="text-4xl">🎵</span>
                            </div>
                        @endif
                        
                        {{-- Badge de Votos Flutuante --}}
                        <div class="absolute -bottom-3 -right-3 bg-green-500 text-white px-3 py-1 rounded-xl shadow-lg flex items-center gap-1 border-2 border-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                            <span class="font-black text-sm">{{ $mostLiked->likes }}</span>
                        </div>
                    </div>

                    <h2 class="text-xl font-black text-slate-800 leading-tight mb-1 px-4">{{ $mostLiked->title }}</h2>
                    <p class="text-indigo-500 font-bold uppercase text-xs tracking-wide mb-4">{{ $mostLiked->artist }}</p>
                @else
                    <div class="py-12 flex flex-col items-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Ainda sem votos hoje.</p>
                    </div>
                @endif
            </div>

            {{-- 2. BOX: AS 5 MAIS REPETIDAS (Com painel lateral de horários) --}}
            <div class="lg:col-span-8 bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200 flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Ranking de Repetições
                    </h3>
                    <div class="space-y-3">
                        @forelse($mostRepeated as $index => $item)
                            <button 
                                wire:click="showPlayTimes('{{ $item->title }}', '{{ $item->artist }}')"
                                class="w-full flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all text-left group focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            >
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-300 font-black text-xl italic group-hover:text-indigo-400 transition">#{{ $index + 1 }}</span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-800 leading-tight truncate">{{ $item->title }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium uppercase truncate">{{ $item->artist }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full group-hover:scale-110 transition shrink-0">
                                    {{ $item->total }}x
                                </span>
                            </button>
                        @empty
                            <p class="text-sm text-slate-400 italic">Dados insuficientes para ranking.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Painel de Horários --}}
                <div class="w-full md:w-56 bg-slate-50 rounded-2xl p-4 border border-dashed border-slate-200 flex flex-col">
                    <p class="text-[10px] font-black text-slate-400 uppercase mb-4 text-center">Detalhamento</p>
                    
                    @if($selectedSongTitle)
                        <div class="mb-3 text-center px-2">
                            <p class="text-[9px] font-bold text-indigo-600 truncate uppercase" title="{{ $selectedSongTitle }}">{{ $selectedSongTitle }}</p>
                        </div>
                        
                        <div class="space-y-2 overflow-y-auto max-h-60 pr-1 custom-scrollbar flex-1">
                            @foreach($selectedSongTimes as $play)
                                <div class="bg-white px-3 py-2 rounded-lg shadow-sm border border-slate-100 text-center hover:border-indigo-200 transition">
                                    <span class="text-[10px] font-bold text-slate-600 block">
                                        Tocou: {{ \Carbon\Carbon::parse($play->played_at)->translatedFormat('l') }}
                                    </span>
                                    <span class="text-sm font-mono font-black text-indigo-500">
                                        {{ \Carbon\Carbon::parse($play->played_at)->format('H:i') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center px-4 gap-2 opacity-50">
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[10px] text-slate-400 font-medium leading-tight">Clique em uma música para ver os horários</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- LISTA CRONOLÓGICA PAGINADA --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between bg-slate-50/50 gap-4">
                <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">
                    Linha do Tempo
                </h2>
                <div class="bg-white px-4 py-2 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-indigo-500 font-bold text-sm tracking-wide">{{ $dateFull }}</span>
                </div>
            </div>
            
            <div class="divide-y divide-slate-100">
                @forelse($songs as $song)
                    <div class="p-6 hover:bg-indigo-50/30 transition flex flex-col sm:flex-row items-start sm:items-center gap-4 group">
                        <div class="shrink-0">
                            <span class="text-sm font-mono font-black text-indigo-500 bg-white border border-indigo-100 px-3 py-1 rounded-xl shadow-sm">
                                {{ \Carbon\Carbon::parse($song->played_at)->format('H:i') }}
                            </span>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-base font-bold text-slate-800 truncate group-hover:text-indigo-600 transition">{{ $song->title }}</p>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">{{ $song->artist }}</p>
                        </div>

                        {{-- Votos --}}
                        <div class="flex items-center gap-2">
                            @if($song->likes > 0)
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white text-green-600 border border-slate-100 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                                <span class="text-xs font-black">{{ $song->likes }}</span>
                            </div>
                            @endif
                            @if($song->dislikes > 0)
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white text-red-400 border border-slate-100 shadow-sm opacity-50">
                                <svg class="w-3.5 h-3.5 transform rotate-180" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                                <span class="text-xs font-black">{{ $song->dislikes }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-20 text-center">
                        <p class="text-slate-300 italic">Nada para mostrar hoje.</p>
                    </div>
                @endforelse
            </div>

            {{-- LINK DA PAGINAÇÃO --}}
            <div class="p-6 bg-slate-50 border-t border-slate-100">
                {{ $songs->links() }}
            </div>
        </div>
        
        <div class="mt-12 flex justify-center">
            <a href="/" wire:navigate class="group flex items-center gap-3 bg-white px-6 py-3 rounded-full border border-slate-200 shadow-sm hover:border-indigo-500 transition-all">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span class="font-black text-slate-600 group-hover:text-indigo-600 uppercase text-xs tracking-widest">Voltar para a Rádio</span>
            </a>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #6366f1; }
    </style>
</div>