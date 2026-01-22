<div x-data="{ showModal: @entangle('showModal') }"
     @abrir-login.window="showModal = true"
     class="flex items-center">
    
    {{-- Verifica se está logado --}}
    @if(auth('ouvinte')->check())
        <div class="flex items-center gap-3">
            {{-- Nome e Logout --}}
            <div class="flex flex-col text-right hidden sm:block">
                <span class="text-sm font-bold text-white leading-tight">{{ auth('ouvinte')->user()->name }}</span>
                <a href="{{ route('logout') }}" class="text-xs text-red-400 hover:text-red-300 transition">Sair</a>
            </div>
            
            {{-- Avatar --}}
            @if(auth('ouvinte')->user()->avatar)
                <img src="{{ auth('ouvinte')->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-500 shadow-sm">
            @else
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold border-2 border-indigo-400">
                    {{ substr(auth('ouvinte')->user()->name, 0, 1) }}
                </div>
            @endif
            
            {{-- Botão Sair Mobile (Ícone) --}}
            <a href="{{ route('logout') }}" class="sm:hidden text-red-400 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
            </a>
        </div>
    @else
       {{-- Botão de Login --}}
       <a href="{{ route('google-auth') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-bold rounded-full text-white bg-red-600 hover:bg-red-700 transition shadow-lg hover:shadow-red-600/50">
           <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
           </svg>
           Entrar / Cadastrar
       </a>
    @endif

    {{-- MODAL DE LOGIN MANUAL --}}
    {{-- Usamos @teleport para jogar o modal para o final do body, evitando problemas de z-index no player --}}
    @teleport('body')
        <div x-show="showModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" 
             x-transition.opacity 
             x-cloak>
            
            <div @click.away="showModal = false" class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 text-gray-800 relative">
                
                {{-- Botão Fechar --}}
                <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <h2 class="text-2xl font-bold text-center mb-6 text-indigo-700">Acesso do Ouvinte</h2>

                <div class="flex border-b mb-6">
                    <button wire:click="$set('mode', 'login')" class="flex-1 py-3 font-bold text-sm uppercase tracking-wider {{ $mode == 'login' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">Login</button>
                    <button wire:click="$set('mode', 'register')" class="flex-1 py-3 font-bold text-sm uppercase tracking-wider {{ $mode == 'register' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">Cadastro</button>
                </div>

                @if($mode == 'login')
                <form wire:submit.prevent="login" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                        <input type="email" wire:model="loginEmail" class="w-full border-gray-300 border p-3 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input type="password" wire:model="loginPassword" class="w-full border-gray-300 border p-3 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-bold shadow-lg transition transform active:scale-95">Entrar</button>
                </form>
                @else
                <form wire:submit.prevent="register" class="space-y-4">
                    <input type="text" wire:model="name" placeholder="Nome Completo" class="w-full border-gray-300 border p-3 rounded-lg">
                    <input type="email" wire:model="email" placeholder="Seu E-mail" class="w-full border-gray-300 border p-3 rounded-lg">
                    <input type="password" wire:model="password" placeholder="Crie uma Senha" class="w-full border-gray-300 border p-3 rounded-lg">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold shadow-lg transition transform active:scale-95">Cadastrar</button>
                </form>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-500 mb-3">Ou acesse com sua rede social</p>
                    <a href="{{ route('google-auth') }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/></svg>
                        Google
                    </a>
                </div>
            </div>
        </div>
    @endteleport
</div>