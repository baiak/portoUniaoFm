<div>
   <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    {{-- Cabeçalho --}}
    <header class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            {{ $page->title }}
        </h1>
    </header>

    {{-- Conteúdo Rico (Formatado pelo Tailwind Typography) --}}
    @if($page->content)
        <article class="prose prose-lg prose-slate max-w-none mb-10">
            {!! $page->content !!}
        </article>
    @endif

    {{-- Embeds / Mapas / HTML Puro --}}
    @if(!empty($page->html_code))
        <section class="w-full my-8 aspect-video rounded-lg overflow-hidden shadow-lg bg-gray-100">
            {{-- Aqui o iframe é renderizado sem sanitização --}}
            {!! $page->html_code !!}
        </section>
    @endif
</div>
