<div>
    {{-- Este é o conteúdo que aparecerá dentro do $slot --}}
    @if($settings)
        <h1 class="text-3xl font-bold">{{ $settings->nome }}</h1>
        <p>{{ $settings->slogan }}</p>
    @endif

    <div class="mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
    @foreach($banners as $banner)
        <div class="relative overflow-hidden rounded-xl shadow-lg group">
            <img src="{{ $banner->url }}" alt="{{ $banner->titulo }}" class="w-full h-64 object-cover transition duration-300 group-hover:scale-105">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                    <h3 class="text-white font-bold text-lg"><a href="{{ $banner->link_url }}" class="text-white font-bold text-lg">{{ $banner->titulo }}</a></h3>
                    <h4 class="text-white text-sm">{!! $banner->descricao !!}</h4>
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>