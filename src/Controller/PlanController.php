<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TvShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanController extends AbstractController
{
    #[Route('/plan', name: 'plan')]
    public function list(
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

    
        return $this->render('plan/list.html.twig',
            [
                "hostname" => $hostname,
                "urls" => $urls
            ]
    
        );
        
       
    }
}
