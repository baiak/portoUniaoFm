<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Porto União FM' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    @livewireStyles
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md p-4 mb-6">
        <div class="container mx-auto">
            <a href="/" wire:navigate class="text-xl font-bold text-blue-600 uppercase">
                Painel do Ouvinte
            </a>
            <livewire:header-ouvinte />
        </div>
    </nav>

    <main class="container mx-auto px-4">
        {{-- O CONTEÚDO DA HOME SERÁ INJETADO AQUI: --}}
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>