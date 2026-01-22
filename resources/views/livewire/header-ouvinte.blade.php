<div x-data="{ showModal: @entangle('showModal') }"
    @abrir-login.window="showModal = true">
    
    {{-- MUDANÇA AQUI: Trocamos 'justify-between' por 'justify-end' --}}
    <nav class="bg-white shadow-sm py-4 px-6 flex justify-end items-center border-b">
        
        <div>
            @if(auth('ouvinte')->check())
            <div class="flex items-center gap-4">
                {{-- Adicionei a imagem do avatar aqui para ficar mais legal --}}
                @if(auth('ouvinte')->user()->avatar)
                    <img src="{{ auth('ouvinte')->user()->avatar }}" class="w-8 h-8 rounded-full border border-gray-200">
                @endif
                
                <span class="text-gray-700">Olá, <b>{{ auth('ouvinte')->user()->name }}</b></span>
                
                {{-- Botão de sair --}}
                <button wire:click="logout" wire:loading.attr="disabled" class="text-sm text-red-500 hover:underline disabled:opacity-50 ml-2">
                    Sair
                </button>
            </div>
            @else
               {{-- Botão de Login --}}
               <a href="{{ route('google-auth') }}" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition">
                   <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                   </svg>
                   Login com Google
               </a>
            @endif
        </div>

        {{-- O modal continua igual aqui para baixo... --}}
        <div x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            x-transition
            x-cloak>
             {{-- ... conteúdo do modal ... --}}
             <div @click.away="showModal = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 text-gray-800">
                {{-- (Mantenha o resto do seu código do modal aqui) --}}
                <div class="flex border-b mb-4">
                    <button wire:click="$set('mode', 'login')"
                        class="flex-1 py-2 font-bold {{ $mode == 'login' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500' }}">
                        Login
                    </button>
                    <button wire:click="$set('mode', 'register')"
                        class="flex-1 py-2 font-bold {{ $mode == 'register' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500' }}">
                        Cadastro
                    </button>
                </div>

                @if($mode == 'login')
                <form wire:submit.prevent="login" class="space-y-4">
                    <div>
                        <input type="email" wire:model="loginEmail" placeholder="E-mail"
                            class="w-full border p-2 rounded @error('loginEmail') border-red-500 @enderror">
                        @error('loginEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="password" wire:model="loginPassword" placeholder="Senha"
                            class="w-full border p-2 rounded @error('loginPassword') border-red-500 @enderror">
                        @error('loginPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-600 text-white py-2 rounded font-bold disabled:bg-gray-400">
                        <span wire:loading.remove wire:target="login">Entrar</span>
                        <span wire:loading wire:target="login">Autenticando...</span>
                    </button>
                </form>
                @else
                <form wire:submit.prevent="register" class="space-y-3">
                    <div>
                        <input type="text" wire:model="name" placeholder="Nome completo"
                            class="w-full border p-2 rounded @error('name') border-red-500 @enderror">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="email" wire:model="email" placeholder="E-mail"
                            class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="telefone" placeholder="Telefone (opcional)"
                            class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <input type="password" wire:model="password" placeholder="Crie uma senha"
                            class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled" class="w-full bg-green-600 text-white py-2 rounded font-bold disabled:bg-gray-400">
                        <span wire:loading.remove wire:target="register">Criar Conta</span>
                        <span wire:loading wire:target="register">Processando...</span>
                    </button>
                </form>
                @endif

                <button @click="showModal = false" class="mt-4 w-full text-center text-gray-400 text-sm hover:text-gray-600">
                    Cancelar
                </button>
            </div>
        </div>
    </nav>
</div>