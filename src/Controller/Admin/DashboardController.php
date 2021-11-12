<?php

namespace App\Controller\Admin;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\social;
use App\Entity\Client;
use App\Entity\Roles;
use App\Entity\Customer;
use App\Entity\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $customer = $this->getDoctrine()->getRepository(Customer::class);
        
        return $this->render('admin/dashboard.html.twig', [
            
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Stage Juin');
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Utilisateurs', 'fa fa-user-circle');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Roles', 'fas fa-address-card', Roles::class);
        yield MenuItem::linkToCrud('Social', 'fas fa-handshake', Social::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-money-bill-alt', Client::class);
        yield MenuItem::linkToCrud('Customer', 'fas fa-money-bill-alt', Customer::class);
        yield MenuItem::linkToCrud('ResetPassReq', 'fas fa-bell', ResetPasswordRequest::class);
        yield MenuItem::section('Blog', 'fa fa-file-archive');
        yield MenuItem::linkToCrud('Category', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Article', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Comment', 'fas fa-comments', Comment::class);
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'home');
    }
}
