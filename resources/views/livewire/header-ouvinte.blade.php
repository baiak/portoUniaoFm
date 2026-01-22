<div x-data="{ showModal: @entangle('showModal') }"
    @abrir-login.window="showModal = true">
    
    {{-- CSS FIX: 'justify-end' joga tudo para a direita --}}
    <nav class="bg-white shadow-sm py-4 px-6 flex justify-end items-center border-b h-20">
        
        {{-- Área do Usuário / Botão --}}
        <div>
            @if(auth('ouvinte')->check())
                {{-- USUÁRIO LOGADO --}}
                <div class="flex items-center gap-4">
                    <div class="flex flex-col text-right hidden sm:block">
                        <span class="text-sm font-bold text-gray-800">{{ auth('ouvinte')->user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-xs text-red-500 hover:text-red-700">Sair</a>
                    </div>
                    
                    @if(auth('ouvinte')->user()->avatar)
                        <img src="{{ auth('ouvinte')->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-100">
                    @else
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ substr(auth('ouvinte')->user()->name, 0, 1) }}
                        </div>
                    @endif
                    
                    {{-- Botão Sair (Mobile) --}}
                    <a href="{{ route('logout') }}" class="sm:hidden text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    </a>
                </div>
            @else
               {{-- BOTÃO DE LOGIN --}}
               <a href="{{ route('google-auth') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition shadow-sm">
                   <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                   </svg>
                   Entrar com Google
               </a>
            @endif
        </div>

        {{-- MODAL DE LOGIN MANUAL (MANTIDO) --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-transition x-cloak>
            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 text-gray-800">
                <div class="flex border-b mb-4">
                    <button wire:click="$set('mode', 'login')" class="flex-1 py-2 font-bold {{ $mode == 'login' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500' }}">Login</button>
                    <button wire:click="$set('mode', 'register')" class="flex-1 py-2 font-bold {{ $mode == 'register' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500' }}">Cadastro</button>
                </div>

                @if($mode == 'login')
                <form wire:submit.prevent="login" class="space-y-4">
                    <input type="email" wire:model="loginEmail" placeholder="E-mail" class="w-full border p-2 rounded">
                    <input type="password" wire:model="loginPassword" placeholder="Senha" class="w-full border p-2 rounded">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-bold">Entrar</button>
                </form>
                @else
                <form wire:submit.prevent="register" class="space-y-3">
                    <input type="text" wire:model="name" placeholder="Nome" class="w-full border p-2 rounded">
                    <input type="email" wire:model="email" placeholder="E-mail" class="w-full border p-2 rounded">
                    <input type="password" wire:model="password" placeholder="Senha" class="w-full border p-2 rounded">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold">Cadastrar</button>
                </form>
                @endif
                <button @click="showModal = false" class="mt-4 w-full text-center text-sm text-gray-400">Cancelar</button>
            </div>
        </div>
    </nav>
</div>