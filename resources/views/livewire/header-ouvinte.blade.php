<div x-data="{ showModal: @entangle('showModal') }"
    @abrir-login.window="showModal = true">
    <nav class="bg-white shadow-sm py-4 px-6 flex justify-between items-center border-b">
        <div x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            x-transition
            x-cloak>

            <div @click.away="showModal = false" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 text-gray-800">

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