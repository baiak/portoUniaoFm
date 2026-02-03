<div class="max-w-5xl mx-auto py-10 px-4">

    {{-- Cabeçalho --}}
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
             <p class="text-gray-500 mt-2">Ouça a seleção especial abaixo.</p>
        </div>
    </div>

    {{-- Área do Player (Renderiza o HTML do Banco) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-center items-center">
        
        @if(!empty($special->playlist_html))
            {{-- Wrapper para garantir que o iframe fique responsivo se necessário --}}
            <div class="w-full overflow-hidden rounded-lg">
                {!! $special->playlist_html !!}
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Nenhum player disponível para este especial.</p>
            </div>
        @endif

    </div>

</div>