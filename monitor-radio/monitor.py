import asyncio
import aiohttp
import os
import time
from shazamio import Shazam
from dotenv import load_dotenv
from pathlib import Path

# ==============================================================================
# 1. CARREGAR CONFIGURAÇÕES
# ==============================================================================

caminho_env = Path(__file__).resolve().parent.parent / '.env'
if not caminho_env.exists():
    print(f"❌ Erro: Não encontrei o arquivo .env em: {caminho_env}")
    exit(1)

load_dotenv(dotenv_path=caminho_env)

app_url = os.getenv("APP_URL")
if app_url:
    API_URL = app_url.rstrip('/') + "/api"
else:
    API_URL = os.getenv("API_URL")

API_TOKEN = os.getenv("API_TOKEN")
STREAM_URL = os.getenv("STREAM_URL")
GRAVACAO_SEGUNDOS = int(os.getenv("GRAVACAO_SEGUNDOS", 10))
ARQUIVO_TEMP = "temp_audio.mp3"

if not API_TOKEN or not STREAM_URL or not API_URL:
    print("❌ Configuração incompleta no .env")
    exit(1)

# ==============================================================================
# LISTA SEGURA DE BLOQUEIO
# ==============================================================================
TERMOS_IGNORADOS = [
    "Porto União FM", "A Melhor Programação", "Locução", 
    "Comercial", "Jingle", "Vinheta", "Hora Certa"
]

# ==============================================================================
# FUNÇÕES MELHORADAS
# ==============================================================================

async def gravar_stream_ffmpeg():
    """Grava o áudio do stream com proteções contra travamento."""
    if os.path.exists(ARQUIVO_TEMP):
        try: os.remove(ARQUIVO_TEMP)
        except: pass

    # -reconnect tenta manter a conexão viva se houver oscilação
    cmd = [
        'ffmpeg', '-y', '-hide_banner', '-loglevel', 'error',
        '-reconnect', '1', '-reconnect_streamed', '1', '-reconnect_delay_max', '5',
        '-i', STREAM_URL,
        '-t', str(GRAVACAO_SEGUNDOS),
        '-ac', '1', '-ar', '44100', '-f', 'mp3',
        ARQUIVO_TEMP
    ]

    print(f"🎙️ Gravando {GRAVACAO_SEGUNDOS}s do stream...")
    
    try:
        process = await asyncio.create_subprocess_exec(
            *cmd, stdout=asyncio.subprocess.PIPE, stderr=asyncio.subprocess.PIPE
        )
        
        # O wait_for impede que o Python fique travado se o FFmpeg "pendurar"
        try:
            await asyncio.wait_for(process.communicate(), timeout=GRAVACAO_SEGUNDOS + 15)
        except asyncio.TimeoutError:
            print("⏳ Erro: FFmpeg demorou demais e foi interrompido (Timeout).")
            try: process.kill()
            except: pass
            return False

        if process.returncode == 0 and os.path.exists(ARQUIVO_TEMP):
            tamanho = os.path.getsize(ARQUIVO_TEMP)
            if tamanho > 1000: # Garante que não é um arquivo vazio
                print(f"✅ Áudio capturado com sucesso ({tamanho} bytes).")
                return ARQUIVO_TEMP
            else:
                print("⚠️ Áudio capturado está vazio ou muito pequeno.")
                return False
        else:
            print(f"❌ Erro no FFmpeg. Código: {process.returncode}")
            return False
    except Exception as e:
        print(f"⚠️ Falha técnica no FFmpeg: {e}")
        return False

async def obter_ultima_musica(session):
    headers = {'Authorization': f'Bearer {API_TOKEN}', 'Accept': 'application/json'}
    try:
        async with session.get(f"{API_URL}/current-song", headers=headers, timeout=10) as resp:
            if resp.status == 200:
                return await resp.json()
            return None
    except Exception as e:
        print(f"📡 Erro ao consultar API: {e}")
        return None

async def enviar_atualizacao(session, dados):
    headers = {'Authorization': f'Bearer {API_TOKEN}', 'Accept': 'application/json'}
    try:
        async with session.post(f"{API_URL}/update-song", json=dados, headers=headers, timeout=10) as resp:
            print(f"📤 Resposta API: {resp.status}")
    except Exception as e:
        print(f"⚠️ Falha no envio para API: {e}")

def normalizar(texto):
    if not texto: return ""
    return ''.join(e for e in texto.lower() if e.isalnum())

# ==============================================================================
# LOOP PRINCIPAL
# ==============================================================================

async def main():
    shazam = Shazam()
    print("--- MONITOR DE RÁDIO INICIADO ---")
    print(f"🔗 API: {API_URL}")
    print(f"📻 Stream: {STREAM_URL}")
    print("---------------------------------")
    
    connector = aiohttp.TCPConnector(ssl=False)
    async with aiohttp.ClientSession(connector=connector) as session:
        while True:
            arquivo = await gravar_stream_ffmpeg()
            
            if arquivo:
                try:
                    print("🔍 Enviando para o Shazam...")
                    resultado = await shazam.recognize(arquivo)
                    
                    artista = "Desconhecido"
                    titulo = "Locução / Comercial"
                    capa = None
                    tipo = "station"

                    if 'track' in resultado:
                        track = resultado['track']
                        artista = track.get('subtitle', 'Desconhecido')
                        titulo = track.get('title', 'Desconhecido')
                        capa = track.get('images', {}).get('coverart', None)
                        tipo = "song"
                    
                    # Verificação de Bloqueio
                    termo_bloqueio = None
                    for t in TERMOS_IGNORADOS:
                        if t.lower() in titulo.lower() or t.lower() in artista.lower():
                            tipo = "station"
                            termo_bloqueio = t
                            break
                    
                    if tipo == 'station':
                        motivo = f"Termo '{termo_bloqueio}'" if termo_bloqueio else "Não identificado"
                        print(f"🚫 Ignorado: {artista} - {titulo} ({motivo})")
                    else:
                        print(f"🎵 Identificado: {artista} - {titulo}")

                        # Lógica de Atualização
                        ultima = await obter_ultima_musica(session)
                        enviar = False

                        if not ultima:
                            enviar = True
                        else:
                            bd_artist = normalizar(ultima.get('artist'))
                            bd_title = normalizar(ultima.get('title'))
                            if normalizar(artista) != bd_artist or normalizar(titulo) != bd_title:
                                print("✅ Nova música detectada!")
                                enviar = True
                            else:
                                print("🔁 Mantendo: música ainda é a mesma.")

                        if enviar:
                            payload = {'artist': artista, 'title': titulo, 'cover_url': capa, 'type': 'song'}
                            await enviar_atualizacao(session, payload)

                except Exception as e:
                    print(f"⚠️ Erro no processamento: {e}")
                
                if os.path.exists(arquivo): os.remove(arquivo)
            else:
                print("❌ Falha na captura do áudio. Tentando novamente em breve...")
            
            print(f"⏳ Aguardando 15s para o próximo ciclo...\n")
            await asyncio.sleep(15)

if __name__ == "__main__":
    try:
        asyncio.run(main())
    except KeyboardInterrupt:
        print("\n👋 Monitor encerrado pelo usuário.")