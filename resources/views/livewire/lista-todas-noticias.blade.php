<div>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4">
            <header class="text-center mb-16">
                <h1 class="text-4xl font-black text-gray-900">PORTAL DE NOTÍCIAS</h1>
                <div class="h-1 w-20 bg-indigo-600 mx-auto mt-4 rounded-full"></div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @foreach($noticias as $noticia)
                <article class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden border border-gray-100 flex flex-col">
                    @if($noticia->imagem)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($noticia->imagem) }}" class="h-48 w-full object-cover">
                    @endif
                    <div class="p-6 flex flex-col flex-1">
                        <span class="text-indigo-600 text-xs font-bold mb-2 uppercase">{{ $noticia->publicado_em?->format('d M, Y') }}</span>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ $noticia->titulo }}</h2>
                        <a href="{{ route('noticia.show', $noticia->slug) }}" class="mt-auto bg-indigo-50 text-indigo-600 text-center py-2 rounded-lg font-bold hover:bg-indigo-600 hover:text-white transition">
                            Abrir Notícia
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $noticias->links() }}
            </div>
        </div>
    </div>
</div>