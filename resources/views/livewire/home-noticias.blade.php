<div>
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 uppercase tracking-tight border-l-4 border-indigo-600 pl-4">
                        Fique por dentro
                    </h2>
                    <p class="text-gray-500 mt-2">Últimas notícias</p>
                </div>
                <a href="/noticias" class="hidden md:block text-indigo-600 font-bold hover:underline">
                    Ver todas as notícias →
                </a>
            </div>

            @if($noticias->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                <p class="text-gray-400">Nenhuma notícia publicada no momento.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($noticias as $noticia)
                <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 flex flex-col">

                    <div class="relative h-48 overflow-hidden">
                        @if($noticia->imagem)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($noticia->imagem) }}"
                            alt="{{ $noticia->titulo }}"
                            class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        <div class="absolute top-4 left-4 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ $noticia->publicado_em?->format('d/m/Y') ?? $noticia->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight mb-3">
                            {{ $noticia->titulo }}
                        </h3>

                        <div class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {!! Str::limit(strip_tags($noticia->conteudo), 120) !!}
                        </div>

                        <div class="mt-auto">
                            <a href="/noticia/{{ $noticia->slug }}"
                                class="inline-flex items-center text-indigo-600 font-bold text-sm hover:gap-2 transition-all">
                                Ler notícia completa
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-8 md:hidden">
                <a href="/noticias" class="block text-center bg-white border border-gray-200 text-gray-700 py-3 rounded-xl font-bold">
                    Ver todas as notícias
                </a>
            </div>
            @endif
        </div>
    </section>
</div>