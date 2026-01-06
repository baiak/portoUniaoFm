<div>
    <nav class="bg-white shadow-sm py-4 px-6 flex justify-between items-center border-b">
        <div class="font-bold text-xl text-indigo-600">Minha Rádio SaaS</div>

        <div>
            @if(auth('ouvinte')->check())
            <div class="flex items-center gap-4">
                <span class="text-gray-700">Olá, <b>{{ auth('ouvinte')->user()->name }}</b></span>
                <button wire:click="logout" class="text-sm text-red-500 hover:underline">Sair</button>
            </div>
            @else
            <button @click="$wire.set('showModal', true)" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Entrar / Cadastrar
            </button>
            @endif
        </div>

        <div x-show="$wire.showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div @click.away="$wire.set('showModal', false)" class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">

                <div class="flex border-b mb-4">
                    <button @click="$wire.set('mode', 'login')" :class="$wire.mode == 'login' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="flex-1 py-2 font-bold">Login</button>
                    <button @click="$wire.set('mode', 'register')" :class="$wire.mode == 'register' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="flex-1 py-2 font-bold">Cadastro</button>
                </div>

                @if($mode == 'login')
                <form wire:submit.prevent="login" class="space-y-4">
                    <input type="email" wire:model="loginEmail" placeholder="E-mail" class="w-full border p-2 rounded">
                    <input type="password" wire:model="loginPassword" placeholder="Senha" class="w-full border p-2 rounded">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-bold">Entrar</button>
                </form>
                @else
                <form wire:submit.prevent="register" class="space-y-3">
                    <input type="text" wire:model="name" placeholder="Nome completo" class="w-full border p-2 rounded">
                    <input type="email" wire:model="email" placeholder="E-mail" class="w-full border p-2 rounded">
                    <input type="text" wire:model="telefone" placeholder="Telefone (opcional)" class="w-full border p-2 rounded">
                    <input type="password" wire:model="password" placeholder="Crie uma senha" class="w-full border p-2 rounded">
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold">Criar Conta</button>
                </form>
                @endif

                <button @click="$wire.set('showModal', false)" class="mt-4 w-full text-center text-gray-400 text-sm">Fechar</button>
            </div>
        </div>
    </nav>
</div>