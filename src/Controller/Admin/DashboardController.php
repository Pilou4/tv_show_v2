<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Character;
use App\Entity\Person;
use App\Entity\Season;
use App\Entity\TvShow;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // title barre de navigation
            ->setFaviconPath('favicon.png')
            ->setTitle('Page d\'administration tv_show');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('page d\'accueil','fas fa-campground', 'homepage');
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Tv_show', 'fas fa-tv', TvShow::class);
        yield MenuItem::linkToCrud('Personnage', 'fas fa-id-card', Person::class);
        yield MenuItem::linkToCrud('Acteurs', 'fas fa-user-astronaut', Character::class);
        yield MenuItem::linkToCrud('Saisons', 'fas fa-cloud-sun', Season::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
// <i class="las la-home"></i><i class="las la-campground"></i>