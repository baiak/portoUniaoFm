<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Porto União FM' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 antialiased">
    
    <div class="sticky top-0 z-50">
        @persist('player')
        <livewire:radio-player />
        @endpersist
    </div>

    <main class="container mx-auto px-4 py-8">
        {{ $slot }}
    </main>
    
    @livewireScripts
</body>
</html>