<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-adsense-account" content="ca-pub-6803402036116581">
    <title>{{ $title ?? 'Porto União FM' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
    @php
        $menuPages = \App\Models\Page::where('is_in_menu', true)->get();
        $footerPages = \App\Models\Page::where('is_in_footer', true)->get();
    @endphp
</head>
<body class="bg-gray-100 antialiased">
    
    <div class="sticky top-0 z-50">
        @persist('player')
        <livewire:radio-player />
        @endpersist
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
            <div class="container mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
      
                        {{-- Links Desktop --}}
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                                Início
                            </a>
                            
                            {{-- Loop das Páginas do Menu --}}
                            @foreach($menuPages as $page)
                                <a href="{{ route('pages.show', $page->slug) }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
                                    {{ $page->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Botão Hamburger (Mobile) --}}
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Mobile (Dropdown) --}}
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="/" class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Início
                    </a>
                    @foreach($menuPages as $page)
                        <a href="{{ route('pages.show', $page->slug) }}" class="block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            {{ $page->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
    </div>

    <main class="container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-gray-300 py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Coluna 1: Sobre --}}
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Porto União FM</h3>
                    <p class="text-sm">
                        A melhor rádio da região. Trazendo música e informação de qualidade para você.
                    </p>
                </div>

                {{-- Coluna 2: Links Úteis (Dinâmicos) --}}
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Informações</h3>
                    <ul class="space-y-2">
                        @foreach($footerPages as $page)
                            <li>
                                <a href="{{ route('pages.show', $page->slug) }}" class="hover:text-white transition-colors text-sm">
                                    {{ $page->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Coluna 3: Contato / Social --}}
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Contato</h3>
                    <p class="text-sm mb-2">📍 Rua Principal, 123 - Centro</p>
                    <p class="text-sm">📞 (00) 1234-5678</p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} Porto União FM. Todos os direitos reservados.
            </div>
        </div>
    </footer>
    <livewire:cookie-consent />    
    @livewireScripts
</body>
</html>