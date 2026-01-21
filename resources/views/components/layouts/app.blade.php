<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Porto União FM' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 pt-16">
    <div class="fixed top-0 left-0 w-full z-50">
        @persist('player')
        <livewire:radio-player />
        @endpersist
       <!-- <livewire:header-ouvinte /> !-->
    </div>
    <main class="container mx-auto px-4">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>