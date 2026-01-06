<div>
    <div class="max-w-lg mx-auto px-4 py-8"> 
        <div class="bg-gray-300 p-6 rounded-xl shadow-xl text-white">
            <form wire:submit.prevent="save"> <h2 class="text-xl font-bold mb-4 text-center text-gray-500">Peça sua Música</h2>

                @if (session()->has('success'))
                    <div class="bg-green-500 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
                @endif
                
                @if (session()->has('error'))
                    <div class="bg-red-500 p-3 rounded mb-4 text-sm">{{ session('error') }}</div>
                @endif

                <input type="text" wire:model="nome" placeholder="Seu Nome" 
                       {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                       class="w-full mb-3 p-2 bg-gray-500 rounded border-none focus:ring-2 focus:ring-indigo-200 {{ auth('ouvinte')->check() ? 'opacity-70 cursor-not-allowed' : '' }}">

                <input type="text" wire:model="telefone" placeholder="WhatsApp (Opcional)" 
                       {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                       class="w-full mb-3 p-2 bg-gray-500 rounded border-none focus:ring-2 focus:ring-indigo-200 {{ auth('ouvinte')->check() ? 'opacity-70 cursor-not-allowed' : '' }}">

                <div class="mb-3">
                    <input type="text"
                        wire:model="musica"
                        placeholder="Qual música quer ouvir?"
                        class="w-full p-2 bg-gray-500 rounded border-none focus:ring-2 focus:ring-indigo-200">
                </div>

                <textarea wire:model="mensagem" placeholder="Seu recado (mande um alô!)" 
                          class="w-full mb-3 p-2 bg-gray-500 rounded border-none focus:ring-2 focus:ring-indigo-200 h-24"></textarea>

                @if(auth('ouvinte')->check())
                    <button type="submit" class="w-full bg-gray-600 hover:bg-indigo-600 text-white font-bold py-3 rounded-lg transition shadow-lg">
                        🚀 Enviar Pedido
                    </button>
                @else
                    <button type="button" @click="$dispatch('abrir-login')" class="w-full bg-gray-600 hover:bg-gray-500 text-white font-bold py-3 rounded-lg transition border border-gray-500">
                        Faça Login para Pedir
                    </button>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    function songSearch() {
        return {
            query: @entangle('musica').live, // Sincroniza o query com a música inicial se houver
            selectedSong: @entangle('musica'),
            results: [],
            searchSongs() {
                if (this.query.length < 3) {
                    this.results = [];
                    return;
                }
                fetch(`https://itunes.apple.com/search?term=${encodeURIComponent(this.query)}&entity=song&limit=5`)
                    .then(r => r.json())
                    .then(d => this.results = d.results);
            },
            select(song) {
                this.selectedSong = `${song.trackName} - ${song.artistName}`;
                this.query = this.selectedSong;
                this.results = [];
            }
        }
    }
</script>