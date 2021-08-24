<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TvShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap', name: 'sitemap', format: 'xml')]
    public function sitemap(
        Request $request,
        TvShowRepository $tvShowRepository,
        CategoryRepository $categoryRepository,
    ): Response {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];
        $urls[] = ['loc' => $this->generateUrl('homepage')];
        $urls[] = ['loc' => $this->generateUrl('tv_show_list')];
        $urls[] = ['loc' => $this->generateUrl('category_list')];
        $urls[] = ['loc' => $this->generateUrl('contact')];
        $urls[] = ['loc' => $this->generateUrl('legal_mentions')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('user_account_create')];
        $urls[] = ['loc' => $this->generateUrl('user_password_change')];

        foreach ($tvShowRepository->findAll() as $tvShows) {
            $urls[] = [
                'loc' => $this->generateUrl('tv_show_view',  ['id' => $tvShows->getId(), 'slug' => $tvShows->getSlug()]), 
                 'lastmod' => $tvShows->getCreatedAt()->format('d-m-Y')
            ];
        }
        foreach ($categoryRepository->findAll() as $categories) {
            $urls[] = [
                'loc' => $this->generateUrl('category_view',  ['id' => $categories->getId()]), 
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'hostname' => $hostname,
                'urls' => $urls,
            ]),200
        );

        $response->headers->set('Content-type', 'text/xml');
        
        return $response;
    }
}
