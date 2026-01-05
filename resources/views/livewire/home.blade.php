<div>
    {{-- Este é o conteúdo que aparecerá dentro do $slot --}}
    @if($settings)
        <h1 class="text-3xl font-bold">{{ $settings->nome }}</h1>
        <p>{{ $settings->slogan }}</p>
    @endif

    <div class="mt-10">
        <p class="text-gray-500 italic text-center">Os banners aparecerão aqui em breve...</p>
    </div>
</div>