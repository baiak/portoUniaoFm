<div>
    <div class="max-w-lg mx-auto px-4 py-8">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">

            <form wire:submit.prevent="save">
                <h2 class="text-2xl font-extrabold mb-6 text-center text-gray-800 tracking-tight uppercase">
                    Peça sua Música
                </h2>

                @if (session()->has('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded-lg mb-4 text-sm font-bold">
                    ✅ {{ session('success') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="bg-red-100 border border-red-200 text-red-700 p-3 rounded-lg mb-4 text-sm font-bold">
                    ❌ {{ session('error') }}
                </div>
                @endif

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Seu Nome</label>
                    <input type="text" wire:model="nome"
                        {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                        class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700 {{ auth('ouvinte')->check() ? 'opacity-60 cursor-not-allowed' : '' }}">
                    @error('nome') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">WhatsApp</label>
                    <input type="text" wire:model="telefone"
                        {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                        class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700 {{ auth('ouvinte')->check() ? 'opacity-60 cursor-not-allowed' : '' }}">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Nome da Música</label>
                    <input type="text" wire:model="musica" placeholder="Ex: Queen - Bohemian Rhapsody"
                        class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700">
                    @error('musica') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                @if(auth('ouvinte')->check())
                <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl transition shadow-lg shadow-indigo-200 flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="save">🚀 ENVIAR PEDIDO</span>
                    <span wire:loading wire:target="save">ENVIANDO...</span>
                </button>
                @else
                <button type="button" @click="$dispatch('abrir-login')" class="w-full bg-white border-2 border-indigo-600 text-indigo-600 font-black py-4 rounded-xl transition hover:bg-indigo-50 flex justify-center items-center gap-2">
                    🔑 FAÇA LOGIN PARA PEDIR
                </button>
                <p class="text-center text-gray-400 text-[10px] mt-3 uppercase tracking-widest">É rápido e gratuito</p>
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