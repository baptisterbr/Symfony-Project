<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Article', 'fas fa-tags', Article::class)->setController(ArticleCrudController::class);
        yield MenuItem::linkToCrud('Message', 'fas fa-envelope', Message::class)->setController(MessageCrudController::class);
        yield MenuItem::linkToCrud('Order', 'fas fa-file-invoice', Order::class)->setController(OrderCrudController::class);
        yield MenuItem::linkToCrud('Shop', 'fas fa-shopping-cart', Shop::class)->setController(ShopCrudController::class);
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class)->setController(UserCrudController::class);
    }
}
