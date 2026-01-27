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
# LISTA SEGURA DE BLOQUEIO (Editada)
# ==============================================================================
# Só bloqueia termos que CERTEZA são da rádio ou falhas
TERMOS_IGNORADOS = [
    "Porto União FM", 
    "A Melhor Programação", 
    "Locução", 
    "Comercial",
    "Jingle",
    "Vinheta",
    "Hora Certa"
    # Removi "Ao Vivo", "Unknown" e "Rádio" pois bloqueavam músicas reais
]

# ==============================================================================
# FUNÇÕES
# ==============================================================================

async def gravar_stream_ffmpeg():
    if os.path.exists(ARQUIVO_TEMP):
        try: os.remove(ARQUIVO_TEMP)
        except: pass

    cmd = [
        'ffmpeg', '-y', '-hide_banner', '-loglevel', 'error',
        '-i', STREAM_URL,
        '-t', str(GRAVACAO_SEGUNDOS),
        '-ac', '1', '-ar', '44100', '-f', 'mp3',
        ARQUIVO_TEMP
    ]

    try:
        process = await asyncio.create_subprocess_exec(
            *cmd, stdout=asyncio.subprocess.PIPE, stderr=asyncio.subprocess.PIPE
        )
        await process.communicate()
        return ARQUIVO_TEMP if process.returncode == 0 else False
    except:
        return False

async def obter_ultima_musica(session):
    headers = {'Authorization': f'Bearer {API_TOKEN}', 'Accept': 'application/json'}
    try:
        async with session.get(f"{API_URL}/current-song", headers=headers, timeout=10) as resp:
            return await resp.json() if resp.status == 200 else None
    except:
        return None

async def enviar_atualizacao(session, dados):
    headers = {'Authorization': f'Bearer {API_TOKEN}', 'Accept': 'application/json'}
    try:
        async with session.post(f"{API_URL}/update-song", json=dados, headers=headers, timeout=10) as resp:
            print(f"📤 Atualizado! ({resp.status})")
    except Exception as e:
        print(f"⚠️ Falha no envio: {e}")

def normalizar(texto):
    if not texto: return ""
    return ''.join(e for e in texto.lower() if e.isalnum())

# ==============================================================================
# LOOP PRINCIPAL
# ==============================================================================

async def main():
    shazam = Shazam()
    print("🚀 Monitor Iniciado (Lista de Bloqueio Ajustada)")
    
    connector = aiohttp.TCPConnector(ssl=False)
    async with aiohttp.ClientSession(connector=connector) as session:
        while True:
            arquivo = await gravar_stream_ffmpeg()
            
            if arquivo and os.path.exists(arquivo):
                try:
                    print("🔍 Identificando...")
                    try:
                        resultado = await shazam.recognize(arquivo)
                    except:
                        resultado = {}
                    
                    # Padrão: Se não achar, assume que é Locução
                    artista = "Desconhecido"
                    titulo = "Locução / Comercial"
                    capa = None
                    tipo = "station" # Começa como station (não envia)

                    # Se o Shazam achou musica
                    if 'track' in resultado:
                        match_found = True
                        track = resultado['track']
                        artista = track.get('subtitle', 'Desconhecido')
                        titulo = track.get('title', 'Desconhecido')
                        capa = track.get('images', {}).get('coverart', None)
                        tipo = "song" # Promove para música
                    
                    # VERIFICAÇÃO DE TERMOS PROIBIDOS
                    termo_bloqueio = None
                    for t in TERMOS_IGNORADOS:
                        if t.lower() in titulo.lower() or t.lower() in artista.lower():
                            tipo = "station"
                            termo_bloqueio = t
                            break
                    
                    # === BLOQUEIO ===
                    if tipo == 'station':
                        motivo = f"Termo '{termo_bloqueio}'" if termo_bloqueio else "Não reconhecido pelo Shazam"
                        print(f"🚫 Ignorado: {artista} - {titulo} | Motivo: {motivo}")
                        
                        if os.path.exists(arquivo): os.remove(arquivo)
                        print("⏳ ...\n")
                        await asyncio.sleep(5)
                        continue
                    # ================

                    print(f"🎵 Música Válida: {artista} - {titulo}")

                    # Lógica de Atualização (Só se mudou)
                    ultima = await obter_ultima_musica(session)
                    enviar = False

                    if not ultima:
                        enviar = True
                    else:
                        bd_artist = normalizar(ultima.get('artist'))
                        bd_title = normalizar(ultima.get('title'))
                        new_artist = normalizar(artista)
                        new_title = normalizar(titulo)

                        if bd_artist != new_artist or bd_title != new_title:
                            print("✅ Música Nova! Enviando...")
                            enviar = True
                        else:
                            print("🔁 A mesma música ainda.")

                    if enviar:
                        payload = {'artist': artista, 'title': titulo, 'cover_url': capa, 'type': 'song'}
                        await enviar_atualizacao(session, payload)

                except Exception as e:
                    print(f"⚠️ Erro: {e}")
                
                if os.path.exists(arquivo): os.remove(arquivo)
            
            await asyncio.sleep(15)

if __name__ == "__main__":
    try: asyncio.run(main())
    except KeyboardInterrupt: pass