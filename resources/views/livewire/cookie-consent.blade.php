<div>
    @if($showBanner)
        {{-- Barra Fixa no Rodapé (Full Width) --}}
        <div class="fixed bottom-0 left-0 w-full bg-gray-900 text-white z-[100] border-t border-gray-700 p-4">
            
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Texto Simples --}}
                <div class="text-center md:text-left text-sm md:text-base">
                    <span class="font-bold">Aviso de Cookies:</span> 
                    Utilizamos cookies para oferecer a melhor experiência. Ao continuar, você concorda com nossa <a href="https://www.clube87.com/politica-de-privacidade" class="text-blue-400 hover:underline" target="_blank">política de privacidade</a>.
                </div>

                {{-- Botão Simples e Visível --}}
                <button 
                    wire:click="accept" 
                    class="whitespace-nowrap bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded shadow-sm transition-colors"
                >
                    Aceitar
                </button>

            </div>
        </div>
    @endif
</div>
    
