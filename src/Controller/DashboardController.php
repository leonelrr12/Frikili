<?php

namespace App\Controller;

use App\Entity\Comentarios;
use App\Entity\Posts;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        // Valida usuario dentro
        if(!$user) return $this->redirectToRoute('app_login');
        $em = $this->getDoctrine()->getManager();
        //$posts = $em->getRepository(Posts::class)->findAll();
        $query = $em->getRepository(Posts::class)->getAllPosts();
        $comentarios = $em->getRepository(Comentarios::class)->getComments($user->getId());
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('dashboard/index.html.twig', [
            'pagination' => $pagination,
            'comentarios' => $comentarios
        ]);
    }
}
