<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Noticia;
use App\Models\Special;


class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
  // Criamos a base do sitemap com as páginas estáticas
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/sobre')->setPriority(0.8))
            ->add(Url::create('/politica-de-privacidade')->setPriority(0.5))
            ->add(Url::create('/termos-de-uso')->setPriority(0.5));

        // Agora buscamos as notícias publicadas no banco de dados
        $noticias = Noticia::where('is_published', true)->get();

        foreach ($noticias as $noticia) {
            $sitemap->add(
                Url::create("/noticia/{$noticia->slug}") // Ajuste o prefixo da URL conforme sua rota
                    ->setLastModificationDate($noticia->updated_at)
                    ->setPriority(0.7)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap gerado com sucesso com ' . $noticias->count() . ' notícias!');
    }
}
