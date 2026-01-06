<div>
    <div class="bg-white min-h-screen">
        <article class="max-w-3xl mx-auto px-4 py-16">
            <nav class="mb-8">
                <a href="{{ route('noticias.index') }}" class="text-indigo-600 font-bold flex items-center gap-2 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Voltar para o portal
                </a>
            </nav>

            <header class="mb-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                        Notícia
                    </span>
                    <time class="text-gray-400 text-sm">
                        {{ $noticia->publicado_em?->translatedFormat('d \d\e F \d\e Y') }}
                    </time>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                    {{ $noticia->titulo }}
                </h1>
            </header>

            @if($noticia->imagem)
            <figure class="mb-12">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($noticia->imagem) }}"
                    class="w-full rounded-3xl shadow-2xl object-cover max-h-[500px]">
            </figure>
            @endif

            <div class="prose prose-lg prose-indigo max-w-none text-gray-800 leading-relaxed font-serif">
                {!! $noticia->conteudo !!}
            </div>

            <footer class="mt-16 pt-8 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-gray-500 text-sm italic">Obrigado por acompanhar nossa rádio!</p>
                </div>
            </footer>
        </article>
    </div>
</div>