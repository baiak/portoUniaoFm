<div>
    <div class="max-w-lg mx-auto px-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">

            <form wire:submit.prevent="save">
                <h2 class="text-xl font-bold text-gray-800 pb-6 border-b mb-6">
                    Peça sua música
                </h2>

                @if (session()->has('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded-lg mb-4 text-sm font-bold">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @error('rate_limit')
                    <div class="bg-yellow-100 border border-yellow-200 text-yellow-700 p-3 rounded-lg mb-4 text-sm font-bold">
                        ⏳ {{ $message }}
                    </div>
                @enderror

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Seu Nome</label>
                    <input type="text" wire:model="nome"
                        {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                        class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700 {{ auth('ouvinte')->check() ? 'opacity-70' : '' }}">
                    @error('nome') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">WhatsApp (Opcional)</label>
                    <input type="text" wire:model="telefone"
                        {{ auth('ouvinte')->check() ? 'readonly' : '' }}
                        class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700 {{ auth('ouvinte')->check() ? 'opacity-70' : '' }}">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Nome da Música</label>
                    <div x-data="songSearch()" class="relative">
                        <input type="text" 
                               wire:model.live.debounce.500ms="musica" 
                               @input="searchSongs()"
                               placeholder="Ex: Queen - Bohemian Rhapsody"
                               class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700">
                        
                        <div x-show="results.length > 0" @click.away="results = []" class="absolute z-10 w-full bg-white shadow-lg rounded-xl mt-1 border border-gray-100 max-h-60 overflow-y-auto" style="display: none;">
                            <template x-for="song in results" :key="song.trackId">
                                <div @click="select(song)" class="p-3 hover:bg-indigo-50 cursor-pointer border-b last:border-0 text-sm">
                                    <span class="font-bold text-gray-700" x-text="song.trackName"></span>
                                    <span class="text-xs text-gray-500 block" x-text="song.artistName"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('musica') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
    <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Recadinho (Opcional)</label>
    <textarea wire:model="mensagem" 
              rows="2"
              placeholder="Manda um alô pra galera..."
              class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all text-gray-700 resize-none"></textarea>
    @error('mensagem') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
</div>

                @if(!auth('ouvinte')->check())
                <div class="mb-6 bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                    <label class="block text-xs font-bold text-indigo-500 uppercase mb-2">Prove que é humano: Quanto é?</label>
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-black text-gray-700">{{ $num1 }} + {{ $num2 }} = </span>
                        <input type="number" wire:model="captcha_resposta_usuario" 
                            class="w-20 p-2 text-center font-bold bg-white rounded-lg border border-indigo-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-gray-700">
                    </div>
                    @error('captcha_erro') 
                        <span class="text-red-500 text-xs font-bold block mt-2">❌ {{ $message }}</span> 
                    @enderror
                </div>
                @endif

                <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl transition shadow-lg shadow-indigo-200 flex justify-center items-center gap-2 disabled:opacity-50 disabled:cursor-wait">
                    <span wire:loading.remove wire:target="save">🚀 ENVIAR PEDIDO</span>
                    <span wire:loading wire:target="save">ENVIANDO...</span>
                </button>

                @if(!auth('ouvinte')->check())
                    <p class="text-center text-gray-400 text-[10px] mt-4">
                        Quer agilidade? <button type="button" @click="$dispatch('abrir-login')" class="text-indigo-500 font-bold hover:underline">Faça login</button>
                    </p>
                @endif
                
            </form>
        </div>
    </div>
</div>

<script>
    function songSearch() {
        return {
            query: @entangle('musica').live, 
            selectedSong: @entangle('musica'),
            results: [],
            searchSongs() {
                if (!this.query || this.query.length < 3) {
                    this.results = [];
                    return;
                }
                fetch(`https://itunes.apple.com/search?term=${encodeURIComponent(this.query)}&entity=song&limit=5`)
                    .then(r => r.json())
                    .then(d => this.results = d.results);
            },
            select(song) {
                // Ao selecionar, atualiza diretamente o modelo Livewire
                @this.set('musica', `${song.trackName} - ${song.artistName}`);
                this.results = [];
            }
        }
    }
</script>