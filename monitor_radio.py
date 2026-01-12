import asyncio
import aiohttp
from shazamio import Shazam

# ==========================================
# ⚙️ CONFIGURAÇÕES (Edite aqui)
# ==========================================

# 1. Link da sua rádio (MP3/AAC Stream)
STREAM_URL = 'https://stm4.xcast.com.br:12006/stream'

# 2. URL da sua API Laravel (Use o link do Ngrok se estiver rodando local no Windows)
# Exemplo: 'https://xxxx-xxxx.ngrok-free.app/api/update-song'
API_URL = 'https://tubbier-hygrometrically-olimpia.ngrok-free.dev/api/update-song' 

# 3. O Token que você gerou no "php artisan tinker"
API_TOKEN = 'qdyfpcrd50ynOzfGWPQFWXSgrbRwq6APbsbOrNfZccb1ff3a'

# ==========================================

async def enviar_para_laravel(session, dados):
    headers = {
        "Authorization": f"Bearer {API_TOKEN}",
        "Accept": "application/json"
    }
    
    try:
        async with session.post(API_URL, json=dados, headers=headers) as response:
            if response.status == 201:
                print(f"✅ SUCESSO: '{dados['title']}' enviada com capa para o Laravel!")
            elif response.status == 200:
                print(f"zzz Música repetida. Laravel ignorou.")
            else:
                texto_erro = await response.text()
                print(f"❌ Erro API ({response.status}): {texto_erro}")
    except Exception as e:
        print(f"⚠️ Erro de conexão com o Laravel: {e}")

async def main():
    shazam = Shazam()
    print(">>> 🎧 Monitor de Rádio Iniciado...")
    print(f">>> 📡 Alvo API: {API_URL}")

    while True:
        try:
            print("\n------------------------------------------------")
            print(">>> 📥 Conectando na rádio para ouvir...")
            
            # 1. Baixa 10-12 segundos do áudio da rádio
            async with aiohttp.ClientSession() as session:
                async with session.get(STREAM_URL) as response:
                    if response.status != 200:
                        print(f"❌ Erro na rádio: Status {response.status}")
                        await asyncio.sleep(5)
                        continue

                    # Grava o trecho temporário
                    with open("temp_audio.mp3", 'wb') as f:
                        count = 0
                        async for chunk in response.content.iter_chunked(1024):
                            f.write(chunk)
                            count += 1
                            if count > 350: # +/- 12 segundos (ajuste se precisar)
                                break
            
            # 2. Envia para o Shazam
            print(">>> 🔍 Identificando música...")
            out = await shazam.recognize('temp_audio.mp3')

            # 3. Processa o resultado
            if 'track' in out:
                track = out['track']
                
                # Extrai dados básicos
                titulo = track.get('title', 'Desconhecido')
                artista = track.get('subtitle', 'Desconhecido')
                
                # Extrai a capa (tenta achar a melhor imagem disponível)
                capa_url = None
                if 'images' in track and 'coverart' in track['images']:
                    capa_url = track['images']['coverart']
                
                # Monta o pacote
                payload = {
                    'title': titulo,
                    'artist': artista,
                    'cover_url': capa_url,
                    'type': 'song'
                }

                print(f">>> 🎵 Detectado: {artista} - {titulo}")
                if capa_url:
                    print(f">>> 🖼️  Capa encontrada!")

                # Envia para o Laravel
                async with aiohttp.ClientSession() as api_session:
                    await enviar_para_laravel(api_session, payload)
            
            else:
                print(">>> 🤷 Som não identificado (Locutor/Comercial).")

        except Exception as e:
            print(f">>> 💥 Erro crítico no loop: {e}")
        
        # Espera um pouco antes de checar de novo
        tempo_espera = 15
        print(f">>> ⏳ Aguardando {tempo_espera}s...")
        await asyncio.sleep(tempo_espera)

if __name__ == "__main__":
    loop = asyncio.get_event_loop()
    loop.run_until_complete(main())