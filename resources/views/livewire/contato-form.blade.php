<div>
<div class="flex items-center justify-center py-10 bg-gray-50">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
        
        <div class="bg-blue-600 p-6">
            <h2 class="text-2xl font-bold text-gray-100">Fale Conosco</h2>
            <p class="text-blue-100 text-sm">Preencha os campos abaixo e entraremos em contato.</p>
        </div>

        <div class="p-8">
            @if (session()->has('message'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 text-lg font-semibold animate-pulse">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="enviar" class="space-y-6">
                
                {{-- Nome --}}
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-600 uppercase">Nome</label>
                    <input type="text" wire:model="nome" placeholder="Seu nome completo"
                        class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-xl focus:border-blue-500 focus:bg-white transition-all outline-none @error('nome') border-red-500 @enderror">
                    @error('nome') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-600 uppercase">E-mail</label>
                    <input type="email" wire:model="email" placeholder="seu@email.com"
                        class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-xl focus:border-blue-500 focus:bg-white transition-all outline-none @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                {{-- Assunto --}}
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-600 uppercase">Assunto</label>
                    <input type="text" wire:model="assunto" placeholder="Assunto da mensagem"
                        class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-xl focus:border-blue-500 focus:bg-white transition-all outline-none">
                </div>

                {{-- Mensagem --}}
                <div class="space-y-1">
                    <label class="block text-sm font-bold text-gray-600 uppercase">Mensagem</label>
                    <textarea wire:model="mensagem" rows="4" placeholder="Como podemos ajudar?"
                        class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-xl focus:border-blue-500 focus:bg-white transition-all outline-none resize-none @error('mensagem') border-red-500 @enderror"></textarea>
                    @error('mensagem') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>

                {{-- reCAPTCHA --}}
                <div class="flex justify-center py-2 bg-gray-50 rounded-lg border border-gray-200">
                    <div wire:ignore>
                        <div id="google-recaptcha" 
                             class="g-recaptcha" 
                             data-sitekey="{{ config('services.recaptcha.site_key') }}"
                             data-callback="setCaptcha">
                        </div>
                    </div>
                </div>
                @error('captcha') <div class="text-center"><span class="text-red-500 text-xs font-bold">{{ $message }}</span></div> @enderror

                
         <button type="submit"
        wire:loading.attr="disabled"
        wire:loading.class="opacity-70 cursor-not-allowed"
        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold text-xl py-4 px-6 rounded-xl shadow hover:shadow-lg transition-all duration-300">
    
    <!-- Estado normal -->
    <span wire:loading.remove class="flex items-center justify-center gap-2">
        Enviar
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
    </span>
    
    <!-- Estado de loading -->
    <span wire:loading class="flex items-center justify-center gap-2">
        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
        </svg>
        Enviando...
    </span>
</button>
<small>ou envie um e-mail para: jonathanbaiak@gmail.com</small>
            </form>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function setCaptcha(token) {
            @this.set('captcha', token);
        }
    </script>
</div>
</div>