<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Porto União FM' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    @livewireStyles
</head>
<body class="bg-gray-100 pt-16"> <div class="fixed top-0 left-0 w-full z-50">
        @persist('player')
            <livewire:radio-player />
        @endpersist
    </div>

    <nav class="bg-white shadow-md p-4 mb-6 relative z-40">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" wire:navigate class="text-xl font-bold text-blue-600 uppercase">
                Painel do Ouvinte
            </a>
            
            <livewire:header-ouvinte />
        </div>
    </nav>

    <main class="container mx-auto px-4">
        {{ $slot }}
    </main>
    
    @livewireScripts
</body>
</html>