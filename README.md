# Porto União FM - Sistema de Web Rádio

Este é um sistema completo de gerenciamento e portal para web rádio, desenvolvido com o framework Laravel e o ecossistema TALL Stack. O projeto inclui um painel administrativo robusto para gestão de conteúdo e um script de monitoramento inteligente para reconhecimento de músicas em tempo real.

## 🚀 Tecnologias Utilizadas

O projeto foi construído utilizando as seguintes tecnologias:

* **Framework PHP:** [Laravel 11](https://laravel.com/)
* **Painel Administrativo:** [Filament v3](https://filamentphp.com/) (Gestão de banners, notícias, anunciantes e configurações)
* **Frontend Reativo:** [Livewire](https://livewire.laravel.com/) e [Alpine.js](https://alpinejs.dev/)
* **Estilização:** [Tailwind CSS](https://tailwindcss.com/)
* **Banco de Dados:** MariaDB / MySQL
* **Monitoramento de Áudio:** Python com bibliotecas de reconhecimento de música (ShazamIO).

## ✨ Funcionalidades Principais

* **Player de Rádio:** Interface intuitiva para ouvir a rádio online em tempo real.
* **Reconhecimento de Músicas (Monitor):** Um script Python integrado que monitora o stream de áudio e identifica a música que está tocando, atualizando o histórico no site automaticamente.
* **Gestão de Conteúdo:**
    * **Notícias:** Sistema completo de publicação com categorias.
    * **Banners e Anunciantes:** Gerenciamento de espaços publicitários.
    * **Páginas Customizadas:** Criação dinâmicas de páginas institucionais.
* **Interatividade com o Ouvinte:**
    * **Pedidos de Música:** Formulário para ouvintes solicitarem suas canções favoritas.
    * **Sistema de Votação:** Rankeamento das músicas mais populares (Top Songs).
    * **Área do Ouvinte:** Cadastro e autenticação social (Google Auth).
* **SEO e Utilidades:** Geração automática de Sitemap e comando de limpeza de logs.

## 🛠️ Estrutura do Projeto

* `/app/Filament`: Recursos e esquemas do painel administrativo.
* `/app/Livewire`: Componentes dinâmicos da interface do usuário.
* `/app/Models`: Modelagem dos dados (Programas, Notícias, Ouvintes, Pedidos, etc).
* `/monitor-radio`: Script Python independente para monitoramento do stream de áudio.

## 🔧 Instalação e Configuração

### Pré-requisitos
* PHP 8.2 ou superior
* Composer
* Node.js & NPM
* Python 3.11+ (para o monitor)

### Passo a passo

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/seu-usuario/portouniaofm.git](https://github.com/seu-usuario/portouniaofm.git)
    cd portouniaofm
    ```

2.  **Instale as dependências do PHP:**
    ```bash
    composer install
    ```

3.  **Instale as dependências do Frontend:**
    ```bash
    npm install
    npm run build
    ```

4.  **Configure o ambiente:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Configure as credenciais do banco de dados no arquivo `.env`.*

5.  **Execute as migrações e seeders:**
    ```bash
    php artisan migrate --seed
    ```

6.  **Configuração do Monitor (Python):**
    ```bash
    cd monitor-radio
    python -m venv venv
    source venv/bin/activate  # ou venv\Scripts\activate no Windows
    pip install -r requirements.txt
    ```

## 📈 Comandos Úteis

* **Gerar Sitemap:** `php artisan sitemap:generate`
* **Limpar Logs Antigos:** `php artisan logs:clean` (agendado via cron)

## 📄 Licença

Este projeto está sob a licença [MIT](LICENSE).
